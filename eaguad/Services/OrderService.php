<?php namespace EAguad\Services;

use EAguad\Events\OrderApprovedEvent;
use EAguad\Events\OrderRejectedEvent;
use EAguad\Exception\AlreadyApprovedException;
use EAguad\Exception\AlreadyRejectedException;
use EAguad\Exception\ReviewerDoesNotBelongToCostCentreException;
use EAguad\Model\Order;
use EAguad\Model\User;

class OrderService {
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';
    const STATUS_ALL = null;

    private static $instance = null;
    private $status = null;
    private $limit = 0;
    private $offset  = 0;

    /**
     * OrderService constructor.
     */
    private function __construct()
    {

    }

    /**
     * @param Order $order
     * @param User $user
     * @param string $message
     * @return OrderService
     * @throws AlreadyApprovedException
     * @throws ReviewerDoesNotBelongToCostCentreException
     */
    public function approve(Order $order, User $user, $message = '')
    {
        if ($order->status == static::STATUS_APPROVED) {
            throw new AlreadyApprovedException();
        }

        if (!$order->costCentre->hasReviewer($user)) {
            throw new ReviewerDoesNotBelongToCostCentreException();
        }

        $order->status = static::STATUS_APPROVED;
        $order->save();
        $order->logs->create([
            'reviewer_id' => $user->id,
            'old_status' => $order->status,
            'new_status' => static::STATUS_REJECTED,
            'message' => $message
        ]);

        event(new OrderRejectedEvent($order));

        return $this;
    }

    /**
     * @param Order $order
     * @param User $user
     * @param string $message
     * @return OrderService
     * @throws AlreadyRejectedException
     * @throws ReviewerDoesNotBelongToCostCentreException
     */
    public function reject(Order $order, User $user, $message = '')
    {
        if ($order->status == static::STATUS_REJECTED) {
            throw new AlreadyRejectedException();
        }

        if (!$order->costCentre->hasReviewer($user)) {
            throw new ReviewerDoesNotBelongToCostCentreException();
        }

        $order->status = static::STATUS_REJECTED;
        $order->save();
        $order->logs->create([
            'reviewer_id' => $user->id,
            'old_status' => $order->status,
            'new_status' => static::STATUS_REJECTED,
            'message' => $message
        ]);

        event(new OrderApprovedEvent($order));

        return $this;
    }

    /**
     * @return OrderService
     */
    public function getInstance() : OrderService
    {
        static::$instance = static::$instance ?? new static;
        return static::$instance;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getAll() : \Illuminate\Support\Collection
    {
        return Order::where('status', $this->status)
            ->limit($this->limit)
            ->offset($this->offset)
            ->get();
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

    /**
     * @param int $limit
     * @return OrderService
     */
    public function setLimit(int $limit) : OrderService
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * @param int $offset
     * @return OrderService
     */
    public function setOffset(int $offset) : OrderService
    {
        $this->offset = $offset;

        return $this;
    }

    /**
     * @return int
     */
    public function getStatus() : int
    {
        return $this->status;
    }

    /**
     * @param int $status
     * @return OrderService
     */
    public function setStatus($status) : OrderService
    {
        $this->status = $status;

        return $this;
    }
}
