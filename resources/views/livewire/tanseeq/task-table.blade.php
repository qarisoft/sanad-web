{{--@php use App\Filament\Resources\TaskResource\Pages\ListTasks; @endphp--}}

<div class="w-1/5  flex flex-col p-2 ">

            <div class="flex justify-evenly rounded  text-gray-900 font-bold">
                <div class="p-1.5">الكود</div>
                <div class="p-1.5">الوقت الباقي</div>
            </div>
            <div class="w-full  flex-1 overflow-y-scroll">
                @foreach( $red_data as $r )
                    <div class="flex  p-2 bg-red-600 mt-1 text-gray-100 text-center rounded ">
                        <a href="{{ $a.'/'.$r['task']->id.'/view' }}"
                           class="flex-1" >{{ $r['task']->code }}</a>
                        <div class="flex-1" >
                            {{ number_format(intval($r['time']),2) }}
                            <small>  ساعة </small></div>
                    </div>

                @endforeach
            </div>
            <div class="w-full bg-amber-5d flex-1 overflow-y-scroll">
                @foreach( $blue_data as $r )
                    <div class="flex  p-2 bg-blue-600 mt-1 text-gray-100 text-center rounded ">
                                        @php $a= ''  @endphp
                        <a href="{{ $a.'/'.$r['task']->id.'/view' }}"
                           class="flex-1" >{{ $r['task']->code }}</a>
                        <div class="flex-1" >{{ number_format(intval($r['time']),2) }}<small>  ساعة </small></div>
                    </div>
                @endforeach
            </div>






    @script
    <script>
            window.Echo.join('tasks')
                .subscribed(function () {
                    console.log('subscribed')
                })
                .listen('.tasks',function (a){
                    console.log('dasdasdas',a)
                    $wire.$call('up')
            })
    </script>
    @endscript
</div>

