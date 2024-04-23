{{--@php use App\Filament\Resources\TaskResource\Pages\ListTasks; @endphp--}}
<div class=" ">
{{ $time }}


    @script
    <script>
        window.Echo.join('tasks').listen('.tasks',function (a){
            console.log('dasdasdas',a)
            // $wire.$call('up')
        })
    </script>
    @endscript
</div>

