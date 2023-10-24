<?php
namespace App\Tasks;

class QueueHandler
{
  public function __invoke()
  {
    // $jobs = JobModel::with('mailable')->unprocessed()->get();
    // $jobs = collect($jobs)->splice(0,2);

    // foreach($jobs->all() as $job)
    // {
    //   $recipient = env('MAIL_TO');
    //   if ((app()->environment() == 'production') && $job->recipient)
    //   {
    //     $recipient = $job->recipient;
    //   }
      
    //   try
    //   {
    //     \Mail::to($recipient)->send(new $job->mailable_class($job->mailable));
    //     $job->processed = 1;
    //     $job->save();
    //   }
    //   catch(\Throwable $e)
    //   {
    //     \Log::error($e);
    //     $job->error = $e;
    //     $job->processed = 1;
    //     $job->save();
    //   }
    // }
  }
}