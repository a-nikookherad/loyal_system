<?php


namespace App\Logics\Script\Instance;


use App\Logics\Script\Run;
use App\Models\Role;
use App\Models\Status;
use Illuminate\Support\Facades\DB;

class RoleStatusScript implements Run
{
    private $statuses;

/*    const ROLES = [
        "EDITOR",
        "CALL_CENTER",
        "SUPERVISOR",
        "FINANCIAL",
        "SUPER_ADMIN",
        "SUPPORT",
        "REGISTERER",
        "CUSOTMER"
    ];*/

    const customer = [
        [
            "name" => "in_progress",
            "access" => ["READ", "WRITE"]
        ],
        [
            "name" => "ticket",
            "access" => ["READ"]
        ],
        [
            "name" => "to_edit",
            "access" => ["READ", "WRITE"]
        ],
        [
            "name" => "sms_defect_announcement",
            "access" => ["READ", "WRITE"]
        ],
        [
            "name" => "to_call",
            "access" => ["READ", "WRITE"]
        ],
        [
            "name" => "successful_call",
            "access" => ["READ", "WRITE"]
        ],
        [
            "name" => "unsuccessful_call",
            "access" => ["READ", "WRITE"]
        ],
        [
            "name" => "wrong_phone_number",
            "access" => ["READ", "WRITE"]
        ],
        [
            "name" => "canceled",
            "access" => ["READ"]
        ],
        [
            "name" => "cancellation_and_repay_request",
            "access" => ["READ"]
        ],
        [
            "name" => "canceled_and_repaid",
            "access" => ["READ"]
        ],
        [
            "name" => "repaid",
            "access" => ["READ"]
        ],
        [
            "name" => "confirmed",
            "access" => ["READ"]
        ],
        [
            "name" => "final_approval",
            "access" => ["READ"]
        ],
    ];


    const call_center = [
        [
            "name" => "not_paid",
            "access" => ["READ"]
        ],
        [
            "name" => "ticket",
            "access" => ["READ", "WRITE"],
        ],
        [
            "name" => "successful_call",
            "access" => ["READ", "WRITE"],
        ],
        [
            "name" => "unsuccessful_call",
            "access" => ["READ", "WRITE"],
        ],
        [
            "name" => "wrong_phone_number",
            "access" => ["READ", "WRITE"],
        ],
        [
            "name" => "cancellation_and_repay_request",
            "access" => ["WRITE"],
        ],
        [
            "name" => "to_call",
            "access" => ["READ"],
        ],
        [
            "name" => "sms_defect_announcement",
            "access" => ["READ"],
        ],
    ];
    const editor = [
        [
            "name" => "in_progress",
            "access" => ["WRITE"],
        ],
        [
            "name" => "to_edit",
            "access" => ["READ"],
        ],
    ];
    const financial = [
        [
            "name" => "repaid",
            "access" => ["WRITE"],
        ],
        [
            "name" => "canceled_and_repaid",
            "access" => ["WRITE"],
        ],
    ];
    const supporter = [
        [
            "name" => "not_paid",
            "access" => ["READ"]
        ],
        [
            "name" => "in_progress",
            "access" => ["WRITE"],
        ],
        [
            "name" => "ticket",
            "access" => ["READ"],
        ],
        [
            "name" => "wrong_phone_number",
            "access" => ["READ"],
        ],
    ];
    const registerer = [
        [
            "name" => "not_paid",
            "access" => ["READ"]
        ],
        [
            "name" => "ticket",
            "access" => ["WRITE"],
        ],
        [
            "name" => "final_approval",
            "access" => ["WRITE"],
        ],
        [
            "name" => "confirmed",
            "access" => ["READ"],
        ],
    ];
    const supervisor = [
        [
            "name" => "not_paid",
            "access" => ["READ", "WRITE"]
        ],
        [
            "name" => "in_progress",
            "access" => ["READ", "WRITE"]
        ],
        [
            "name" => "ticket",
            "access" => ["READ", "WRITE"]
        ],
        [
            "name" => "to_edit",
            "access" => ["READ", "WRITE"]
        ],
        [
            "name" => "sms_defect_announcement",
            "access" => ["READ", "WRITE"]
        ],
        [
            "name" => "to_call",
            "access" => ["READ", "WRITE"]
        ],
        [
            "name" => "successful_call",
            "access" => ["READ", "WRITE"]
        ],
        [
            "name" => "unsuccessful_call",
            "access" => ["READ", "WRITE"]
        ],
        [
            "name" => "wrong_phone_number",
            "access" => ["READ", "WRITE"]
        ],
        [
            "name" => "canceled",
            "access" => ["READ", "WRITE"]
        ],
        [
            "name" => "cancellation_and_repay_request",
            "access" => ["READ", "WRITE"]
        ],
        [
            "name" => "canceled_and_repaid",
            "access" => ["READ", "WRITE"]
        ],
        [
            "name" => "repaid",
            "access" => ["READ", "WRITE"]
        ],
        [
            "name" => "confirmed",
            "access" => ["READ", "WRITE"]
        ],
        [
            "name" => "final_approval",
            "access" => ["READ", "WRITE"]
        ],
    ];
    const superadmin = [
        [
            "name" => "not_paid",
            "access" => ["READ", "WRITE"]
        ],
        [
            "name" => "in_progress",
            "access" => ["READ", "WRITE"]
        ],
        [
            "name" => "ticket",
            "access" => ["READ", "WRITE"]
        ],
        [
            "name" => "to_edit",
            "access" => ["READ", "WRITE"]
        ],
        [
            "name" => "sms_defect_announcement",
            "access" => ["READ", "WRITE"]
        ],
        [
            "name" => "to_call",
            "access" => ["READ", "WRITE"]
        ],
        [
            "name" => "successful_call",
            "access" => ["READ", "WRITE"]
        ],
        [
            "name" => "unsuccessful_call",
            "access" => ["READ", "WRITE"]
        ],
        [
            "name" => "wrong_phone_number",
            "access" => ["READ", "WRITE"]
        ],
        [
            "name" => "canceled",
            "access" => ["READ", "WRITE"]
        ],
        [
            "name" => "cancellation_and_repay_request",
            "access" => ["READ", "WRITE"]
        ],
        [
            "name" => "canceled_and_repaid",
            "access" => ["READ", "WRITE"]
        ],
        [
            "name" => "repaid",
            "access" => ["READ", "WRITE"]
        ],
        [
            "name" => "confirmed",
            "access" => ["READ", "WRITE"]
        ],
        [
            "name" => "final_approval",
            "access" => ["READ", "WRITE"]
        ],
    ];



    public function __construct()
    {
        $this->statuses = Status::all();
    }

    public function run()
    {
        try {
            DB::beginTransaction();

            // preventing duplicate data in role_status table by truncating
            DB::table("role_status")->truncate();

            // inserting super_admin
            $this->insertData("super_admin", RoleStatusScript::superadmin);

            // inserting financial role
            $this->insertData("financial", RoleStatusScript::financial);

            // supervisor role
            $this->insertData("supervisor", RoleStatusScript::supervisor);

            // callCenter role
            $this->insertData("call_center", RoleStatusScript::call_center);

            // editor
            $this->insertData("editor", RoleStatusScript::editor);

            // customer
            $this->insertData("customer", RoleStatusScript::customer);

            // supporter
            $this->insertData("supporter", RoleStatusScript::supporter);

            // registerer
            $this->insertData("registerer", RoleStatusScript::registerer);


            DB::commit();
            dd('done.');
        } catch (\Throwable $th) {
            DB::rollBack();
            dd('something went wrong: ' . $th);
        }
    }

    /**
     * this function handles providing nicely formatted data and inserting them to the database
     *
     * @param string $roleName name that will be used in fetching role instance from database
     * @param array $privileges array of different privileges related to that role
     */
    private function insertData(string $roleName, array $privileges) {
        if ($roleName and $privileges) {
            $role = Role::query()->where("name", $roleName)->first();
            if(!$role) {
                dd("$roleName role is not in database");
            }
            $privileges = $this->makeArrayBaseOnAccessLevel($role, $privileges);
            DB::table("role_status")->insert($privileges);
        }
        else {
            dd("required parameter's missing. please inform a technician.");
        }
    }


    /**
     * this function makes an array which is suitable for inserting to database
     * in role_status table.
     *
     * @note this function runs once so considering its high time complexity (O(n^3)) this is not so critical.
     *
     * @param $role
     * @param $grantedPrivileges array
     * @return array
     */
    private function makeArrayBaseOnAccessLevel($role, array $grantedPrivileges): array
    {
        $result = [];
        foreach ($this->statuses as $status) {
            foreach ($grantedPrivileges as $key => $value) {
                if ($value["name"] == $status->name) {
                    foreach ($value["access"] as $v) {
                        array_push($result, [
                            "status_id" => $status->id,
                            "access_level" => $v,
                            "role_id" => $role->id,
                            "created_at" => now(),
                        ]);
                    }
                }
            }
        }
        return $result;
    }


}
