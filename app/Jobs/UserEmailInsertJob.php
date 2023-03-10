<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UserEmailInsertJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    protected $employee;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($employee)
    {
        $this->employee = $employee;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = User::query()->find($this->employee->user_id);
        $user_data = array();

        if ($user) {
            
            if(filter_var($this->employee->email, FILTER_VALIDATE_EMAIL)){
                $user_email = $this->employee->email;
                $user_existence = User::where('id', "!=", $this->employee->user_id)
                    ->where(function ($q) use ($user_email) {
                        $q->where('email', $user_email)
                            ->orWhere('username', $user_email);
                    })                    
                    ->get();
                dump($user_existence->count());    
                if($user_existence->count() > 0){
                    //dump($user_existence);
                    foreach($user_existence as $duplicate_user){
                        Log::debug($duplicate_user);
                        $duplicate_user->update([
                            'email' => $duplicate_user->email."_nov".rand(10,99),
                            'username' => $duplicate_user->username."_de".rand(10,99),
                            'active' => 0
                        ]);
                    }
                }
            }

            if(filter_var($this->employee->email, FILTER_VALIDATE_EMAIL) && $user->email != $this->employee->email ){
                $user_data['email'] = $this->employee->email;
            }
            
            if( $user->username != "" && filter_var($this->employee->email, FILTER_VALIDATE_EMAIL) && filter_var($user->username, FILTER_VALIDATE_EMAIL) && $user->username != $this->employee->email ){
                $user_data['username'] = $this->employee->email;
            }            
            try {
                if(count($user_data) > 0){
                    $user->update($user_data);
                }
            } catch (\Exception $e) {                
                Log::info("Unable to update email user_id: " . $user->id . " | Error: ".$e->getMessage());
                Log::debug($this->employee);
                //Log::debug($e->getMessage());
                Log::info("Err: ".$this->employee->id);
            }
            
        }       
               
        return $user->id ?? null;
    }
}
