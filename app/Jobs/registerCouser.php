<?php

namespace App\Jobs;

use App\Events\MyEvent;
use App\Library\CourseLibrary;
use App\Models\CourseDetail;
use App\Models\notification;
use App\Models\Users;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class registerCouser implements ShouldQueue
{
    use Queueable;

    protected $data;
    protected $user;
    protected $teacher;

    /**
     * Create a new job instance.
     */
    public function __construct($data, $userID, $teacher)
    {
        $this->data = $data;
        $this->user = $userID;
        $this->teacher = $teacher;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $courseDetail = new CourseLibrary();
            $courseDetail->registerCourse($this->data, $this->user, $this->teacher);
        }catch (\Exception $exception){

            Log::error('Error in registerCouser Job: ' . $exception->getMessage());
            throw $exception; // Để job thất bại và được ghi vào queue failed
        }

    }

    public function failed(\Exception $exception)
    {
        // Xử lý khi job thất bại
        Log::error('Job failed permanently: ' . $exception->getMessage());

        // Gửi thông báo đến người dùng hoặc quản trị viên
        session()->flash('error', 'Đăng ký khóa học thất bại: ' . $exception->getMessage());
    }
}
