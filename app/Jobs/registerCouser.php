<?php

namespace App\Jobs;

use App\Models\CourseDetail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class registerCouser implements ShouldQueue
{
    use Queueable;

    protected $data;

    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        CourseDetail::saveDB($this->data);
    }

    public function failed(Exception $exception)
    {
        // Xử lý khi job thất bại
        Log::error('Job failed permanently: ' . $exception->getMessage());

        // Gửi thông báo đến người dùng hoặc quản trị viên
        session()->flash('error', 'Đăng ký khóa học thất bại: ' . $exception->getMessage());
    }
}
