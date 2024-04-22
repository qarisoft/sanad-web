@php use App\Filament\Resources\TaskResource\Pages\ListTasks; @endphp
<x-filament-panels::page
{{--    fullHeight--}}
{{--    class="bg-amber-600"--}}
>
<div class="flex gap-1 hscreen overflow-hidden" >

    <div class="flex-1 p-2 overflow-y-scroll">

        {{ $this->table }}

    </div>

    <div class="w-1/5   flex flex-col p-2">
            <div class="flex justify-evenly rounded bg-red-600d text-gray-900 font-bold">
                            <div class="p-1.5">الكود</div>
                            <div class="p-1.5">الوقت الباقي</div>
            </div>
        <div class="w-full  flex-1 overflow-y-scroll">
                @foreach( $red_data as $r )
                    <div class="flex  p-2 bg-red-600 mt-1 text-gray-100 text-center rounded ">
                        @php $a= ListTasks::getUrl()  @endphp
                        <a href="{{ $a.'/'.$r['task']->id.'/view' }}"
                           class="flex-1" >{{ $r['task']->code }}</a>
                        <div class="flex-1" >{{ number_format(intval($r['time'])/60,2) }}<small>  ساعة </small></div>
                    </div>

                @endforeach
        </div>
        <div class="w-full bg-amber-5d flex-1 overflow-y-scroll">
            @foreach( $blue_data as $r )
                <div class="flex  p-2 bg-blue-600 mt-1 text-gray-100 text-center rounded ">
                    @php $a= ListTasks::getUrl()  @endphp
                    <a href="{{ $a.'/'.$r['task']->id.'/view' }}"
                    class="flex-1" >{{ $r['task']->code }}</a>
                    <div class="flex-1" >{{ number_format(intval($r['time'])/60,2) }}<small>  ساعة </small></div>
                </div>
            @endforeach
        </div>

    </div>


</div>



    <style>
    .fi-main{
        padding: 0;
        max-width: 90rem
    }
    .fi-main section{
        padding: 0 !important;
        row-gap: 0;
    }
    .hscreen{
        height: calc(100vh - 64px);
    }
</style>
</x-filament-panels::page>


