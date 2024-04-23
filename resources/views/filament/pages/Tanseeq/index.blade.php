@php use App\Filament\Resources\TaskResource\Pages\ListTasks; @endphp
<x-filament-panels::page
    fullHeight
>

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
<div class="flex gap-1 hscreen overflow-hidden" >

    <div class="flex-1 p-2 overflow-y-scroll">

        {{ $this->table }}

    </div>
{{--    <livewire:tanseeq.task-table/>--}}
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
                    {{--                @php $a= ''  @endphp--}}
                    <a href="{{ $a.'/'.$r['task']->id.'/view' }}"
                       class="flex-1" >{{ $r['task']->code }}</a>
                    <div class="flex-1" >{{ number_format(intval($r['time']),2) }}<small>  ساعة </small></div>
                </div>
            @endforeach
        </div>



    </div>



@script
<script>
    let ch0 = window.Echo.join('tasks');
    ch0.listen('.tasks',function (e) {
        console.log('ev',e)
        $wire.$call('update')
    })
    ch0.subscribed(function () {
        console.log('sadsadas')
    })
    let ch = window.Echo.join('company');
    ch.here(function (all) {
        console.log('ssssss',all)
    })
    console.log('App\\\\Events\\\\TaskPublished')
    ch.listen('App\\\\Events\\\\TaskPublished',function (event){
        console.log('event',event)
    })

</script>
@endscript
</x-filament-panels::page>

    // console.log()
