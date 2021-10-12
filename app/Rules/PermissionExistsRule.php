<?php

namespace App\Rules;

use App\Models\Permission;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Builder;

class PermissionExistsRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $res = true;
        foreach ($value as $item) {
            $permissionInstance = Permission::query()
                ->where("id", $item)
                ->first();
            if (!$permissionInstance instanceof Permission) {
                $res = false;
            }
        }
        return $res;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __("messages.permission_ids_are_invalid");
    }
}
