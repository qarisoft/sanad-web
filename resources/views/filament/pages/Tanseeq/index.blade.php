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

    <div class="flex-1 p-2 overflow-y-scroll ">

        {{ $this->table }}

    </div>
    <livewire:tanseeq.task-table/>

</x-filament-panels::page>
