<?php namespace EAguad\Services;

use App\Events\OrderApprovedEvent;
use App\Events\OrderRejectedEvent;
use App\Events\OrderSignedEvent;
use EAguad\Exception\AlreadyApprovedException;
use EAguad\Exception\AlreadyRejectedException;
use EAguad\Exception\OrderNotApprovedException;
use EAguad\Exception\ReviewerDoesNotBelongToCostCentreException;
use EAguad\Exception\UserIsNotSignatoryException;
use EAguad\Model\Order;
use EAguad\Model\User;
use StatusNotValidException;

class OrderService {
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';
    const STATUS_SIGNED = 'signed';
    const STATUS_NULL = 'nulled';
    const STATUS_ALL = null;

    private static $instance = null;

    /**
     * OrderService constructor.
     */
    private function __construct()
    {

    }

    /**
     * @param Order $order
     * @param string $message
     * @return OrderService
     * @throws AlreadyApprovedException
     * @throws ReviewerDoesNotBelongToCostCentreException
     */
    public function approve(Order $order, $message = '')
    {
        $user = auth()->user();

        if ($order->status == static::STATUS_APPROVED) {
            throw new AlreadyApprovedException();
        }

        if ($user->cant('approve', $order)) {
            throw new ReviewerDoesNotBelongToCostCentreException();
        }

        $order->logs()->create([
            'reviewer_id' => $user->id,
            'old_status' => $order->status,
            'new_status' => static::STATUS_APPROVED,
            'message' => $message
        ]);

        $order->status = static::STATUS_APPROVED;
        $order->save();

        event(new OrderApprovedEvent($order));

        return $this;
    }

    /**
     * @param Order $order
     * @param string $message
     * @return OrderService
     * @throws UserIsNotSignatoryException
     * @throws OrderNotApprovedException
     */
    public function sign(Order $order, $message = '')
    {
        $user = auth()->user();

        if (!$this->signer || $order->status !== static::STATUS_APPROVED) {
            throw new OrderNotApprovedException();
        }

        if ($user->cant('sign', $order)) {
            throw new UserIsNotSignatoryException();
        }

        $order->logs()->create([
            'reviewer_id' => $user->id,
            'old_status' => $order->status,
            'new_status' => static::STATUS_SIGNED,
            'message' => $message
        ]);

        $order->status = static::STATUS_SIGNED;
        $order->save();

        event(new OrderSignedEvent($order));

        return $this;
    }

    /**
     * @param Order $order
     * @param string $message
     * @return OrderService
     * @throws AlreadyRejectedException
     * @throws ReviewerDoesNotBelongToCostCentreException
     */
    public function reject(Order $order, $message = '')
    {
        $user = auth()->user();

        if ($order->status == static::STATUS_REJECTED) {
            throw new AlreadyRejectedException();
        }

        if ($user->cant('reject', $order)) {
            throw new ReviewerDoesNotBelongToCostCentreException();
        }

        $order->logs()->create([
            'reviewer_id' => $user->id,
            'old_status' => $order->status,
            'new_status' => static::STATUS_REJECTED,
            'message' => $message
        ]);

        $order->status = static::STATUS_REJECTED;
        $order->save();

        event(new OrderRejectedEvent($order));

        return $this;
    }

    /**
     * @param Order $order
     * @param $newStatus
     * @return OrderService
     * @throws AlreadyApprovedException
     * @throws AlreadyRejectedException
     * @throws OrderNotApprovedException
     * @throws ReviewerDoesNotBelongToCostCentreException
     * @throws UserIsNotSignatoryException
     * @throws StatusNotValidException
     */
    public static function changeStatus(Order $order, $newStatus, $message = '')
    {
        if ($newStatus === static::STATUS_APPROVED) {
            return static::getInstance()->approve($order, $message);
        }

        if ($newStatus === static::STATUS_REJECTED) {
            return static::getInstance()->reject($order, $message);
        }

        if ($newStatus === static::STATUS_SIGNED) {
            return static::getInstance()->sign($order, $message);
        }

        if ($newStatus === static::STATUS_PENDING) {
            return static::getInstance()->setPending($order, $message);
        }

        if ($newStatus === static::STATUS_NULL) {
            return static::getInstance()->setNulled($order, $message);
        }

        throw new StatusNotValidException();
    }

    /**
     * @param Order $order
     * @param $message
     * @return OrderService
     * @throws UserIsNotSignatoryException
     */
    public function setPending(Order $order, $message)
    {
        $user = auth()->user();

        if (!$user->can('sign', $order)) {
            throw new UserIsNotSignatoryException();
        }

        $order->logs()->create([
            'reviewer_id' => $user->id,
            'old_status' => $order->status,
            'new_status' => static::STATUS_PENDING,
            'message' => $message
        ]);

        $order->status = static::STATUS_PENDING;
        $order->save();

        return $this;
    }

    /**
     * @param Order $order
     * @param $message
     * @return OrderService
     * @throws StatusNotValidException
     */
    public function setNulled(Order $order, $message)
    {
        $user = auth()->user();

        if (!in_array($order->status, [static::STATUS_SIGNED, static::STATUS_APPROVED])) {
            throw new StatusNotValidException();
        }

        $order->logs()->create([
            'reviewer_id' => $user->id,
            'old_status' => $order->status,
            'new_status' => static::STATUS_NULL,
            'message' => $message
        ]);

        $order->status = static::STATUS_NULL;
        $order->save();

        return $this;
    }

    /**
     * @return OrderService
     */
    public static function getInstance() : OrderService
    {
        static::$instance = static::$instance ?? new static;
        return static::$instance;
    }

    public function getByUser(User $user) : \Illuminate\Support\Collection
    {
        return $user->orders;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }
}
