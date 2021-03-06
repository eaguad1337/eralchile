<?php namespace EAguad\Enum;

class UserRole
{
    const Normal = 'normal';
    const Admin = 'admin';
    const Viewer = 'viewer';
    const Signatory = 'signatory';
    const Approver = 'approver';

    /**
     * @return array
     */
    public static function getAll()
    {
        return array_merge(... array_map(function ($item) {
            return [
               $item => __($item)
            ];
        }, [static::Normal, static::Admin, static::Approver, static::Viewer, static::Signatory]));
    }
}
