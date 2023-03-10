<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class MenuPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function setup($user)
    {
        $permissions = array_merge(
            array_values(config("features.approval_team.actions")),
            array_values(config("features.brand.actions")),
            array_values(config("features.category.actions")),
            array_values(config("features.cost_center.actions")),
            array_values(config("features.department.actions")),
            array_values(config("features.designation.actions")),
            array_values(config("features.employee.actions")),
            array_values(config("features.item.actions")),
            array_values(config("features.role.actions")),
            array_values(config("features.uom.actions")),
            array_values(config("features.vendor.actions")),
            array_values(config("features.company.actions")),
        );
        return $user->hasAnyPermission($permissions);
    }
    public function employee($user)
    {
        $permissions = array_merge(
            array_values(config("features.employee.actions"))
        );
        return $user->hasAnyPermission($permissions);
    }
    public function csPermission($user)
    {
        $permissions = array_merge(
            array_values(config("features.cs_detail.actions"))
        );
        return $user->hasAnyPermission($permissions);
    }
    public function purchaseOrder($user)
    {
        $permissions = array_merge(
            array_values(config("features.purchase_order.actions"))
        );
        return $user->hasAnyPermission($permissions);
    }

    public function report($user)
    {
        $permissions = array_merge(
            array_values(config("features.report.actions"))
        );
        return $user->hasAnyPermission($permissions);
    }
    public function grn($user)
    {
        $permissions = array_merge(
            array_values(config("features.grn.actions"))
        );
        return $user->hasAnyPermission($permissions);
    }
    public function usersList($user)
    {
        $permissions = array_merge(
            array_values(config("features.user.actions"))
        );

        return $user->hasAnyPermission($permissions);
    }

    public function setting($user)
    {
        $permissions = array_merge(
            array_values(config("features.setting.actions"))
        );

        return $user->hasAnyPermission($permissions);
    }



}
