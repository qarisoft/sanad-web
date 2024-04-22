<?php

namespace App\Helper;


enum TaskStatus
{
    case Draft;
    case Published;
    case Uploaded;
    case Reviewed;
    case Approved;
    case RePosted;
    case ReUploaded;
    case Closed;
    case Canceled;
    case NotResponded;
    case ScheduledMoreThanWeek;
    case ScheduledLessThanWeek;
    case ScheduledLessThanADay;
    case AcceptedByViewer;
    case SomethingWrong;
    case EditingData;
    case WaitingToBeSubmitted;
    case WaitingToBeReviewed;


//    public function getId()
//    {
//        return Status::where('code','=',$this->value)->get()->first()->id;

//    }

    public function model()
    {
        return \App\Models\TaskStatus::firstOrCreate([
            'code'=>$this->name
        ]);
    }

}
