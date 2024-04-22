<?php

namespace Database\Seeders;

use App\Helper\TaskStatus;
use App\Models\TaskStatus as Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class TaskStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Status::factory()->createMany([['name' => 'أكتملت', 'color' => '#92d050', 'code' => TaskStatus::Closed],
            ['name' => 'بأنتضار التعميد', 'color' => '#76933c', 'code' => TaskStatus::Uploaded],
            ['name' => 'بأنتضار التقيم', 'color' => '#c4d79b', 'code' => TaskStatus::WaitingToBeReviewed],
            ['name' => 'بأنتضار الرفع', 'color' => '#d8e4bc', 'code' => TaskStatus::WaitingToBeSubmitted],
            ['name' => 'تعديل البيانات ', 'color' => '#ffc000', 'code' => TaskStatus::EditingData],
            ['name' => 'الرقم غير صحيح', 'color' => '#ffff00', 'code' => TaskStatus::SomethingWrong],
            ['name' => 'الغاء الطلب', 'color' => '#ff0000', 'code' => TaskStatus::Canceled],
            ['name' => 'لم يتجاوب', 'color' => '#da9694', 'code' => TaskStatus::NotResponded],
            ['name' => 'تأجيل اكثر من اسبوع', 'color' => '#00b0f0', 'code' => TaskStatus::ScheduledMoreThanWeek],
            ['name' => 'تأجيل اقل من اسبوع', 'color' => '#ffc000', 'code' => TaskStatus::ScheduledLessThanWeek],
            ['name' => 'تأجيل اقل من يوم', 'color' => '#ffc000', 'code' => TaskStatus::ScheduledLessThanADay],
            ['name' => 'لم يرد', 'color' => '#ffff00', 'code' => TaskStatus::NotResponded],
            ['name' => 'تم الأرسال للمعاين', 'color' => '#f2f2f2', 'code' => TaskStatus::AcceptedByViewer],
            ['name' => 'مسودة', 'color' => '#ffffff', 'code' => TaskStatus::Draft],
        ])->map(fn (Model $m) => $m->default = true);

    }
}
