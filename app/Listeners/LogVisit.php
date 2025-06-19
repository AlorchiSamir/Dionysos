<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Log\Visit;

use App\Repositories\Log\VisitRepository;

class LogVisit
{
    
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $request = $this->request;
        if(isset($request->route()->action['as'])){
            $user =  Auth::user();
            $user_id = (isset($user->id)) ? $user->id : null;
            $object_id = (isset($request->id)) ? $request->id : null;
            $object_type = $request->route()->action['as'];

            $visitRepository = new VisitRepository(new Visit());

            $visit = $visitRepository->getByUserAndObject($user_id, $object_type, $object_id);

            if(is_null($visit)){
                $datas = [
                    'user_id' => $user_id,
                    'object_type' => $object_type,
                    'object_id' => $object_id,
                    'count' => 1
                ];
                $visitRepository->save($datas);
            }
            else{
                $visit->count += 1;
                $visit->update();
            }
        }   
    }
}
