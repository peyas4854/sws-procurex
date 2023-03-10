<?php

namespace App\Console\Commands;

use App\Models\Approval;
use App\Models\CsDetail;
use App\Models\PurchaseOrder;
use App\Models\Requisition;
use App\Models\User;
use App\Notifications\ReminderEmailNotification;

use App\Services\SettingService;
use App\Traits\MailMessage;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class ReminderEmail extends Command
{
    use MailMessage;

    protected $notification_days;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'user reminder email about pending pr,cs,po';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->settingService = new SettingService();
        $this->notification_days = $this->settingService->get("notification_days") ?? null;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        echo "notification_days  $this->notification_days ";

        $employeeIds = Approval::query()
            ->where('status', 'pending')
            ->where('created_at', '>', Carbon::now()->subDays($this->notification_days))
            ->pluck('employee_id')->unique();

        foreach ($employeeIds as $employeeId) {
            $data = [];
            $requisitionIds = \App\Models\Approval::query()->with('approvalable')
                ->where('status', 'pending')
                ->where('employee_id', $employeeId)
                ->where('created_at', '>', Carbon::now()->subDays($this->notification_days))
                ->where('approvalable_type', 'App\Models\Requisition')
                ->pluck('approvalable_id')->unique()->toArray();

            $csIds = \App\Models\Approval::query()->with('approvalable')
                ->where('status', 'pending')
                ->where('employee_id', $employeeId)
                ->where('created_at', '>', Carbon::now()->subDays($this->notification_days))
                ->where('approvalable_type', 'App\Models\CsDetail')
                ->pluck('approvalable_id')->unique()->toArray();

            $purchaseOrderIds = \App\Models\Approval::query()->with('approvalable')
                ->where('status', 'pending')
                ->where('employee_id', $employeeId)
                ->where('created_at', '>', Carbon::now()->subDays($this->notification_days))
                ->where('approvalable_type', 'App\Models\PurchaseOrder')
                ->pluck('approvalable_id')->unique()->toArray();

            $data['requisition'] = Requisition::query()
                ->whereIn('id', $requisitionIds)->get();

            $data['csDetail'] = CsDetail::query()
                ->whereIn('id', $csIds)->get();

            $data['purchaseOrder'] = PurchaseOrder::query()
                ->whereIn('id', $purchaseOrderIds)->get();


            $user = self::getUser($employeeId);
            $message = $this->reminderEmail($data);
            if (count($data['requisition']) > 0 || count($data['csDetail']) > 0  || count($data['purchaseOrder']) > 0) {
                Notification::send($user, new ReminderEmailNotification($message));
            }

        }
    }

    public function getUser($employee_id)
    {
        return User::select(["users.id", "users.email"])
            ->join("employees as e", "e.user_id", "users.id")
            ->where("e.id", $employee_id)
            ->whereNotNull("e.user_id")
            ->first();

    }
}
