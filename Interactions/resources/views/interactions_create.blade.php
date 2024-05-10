<x-app-layout :aimx="$aimx">

    <div class="container">

        @include($aimx['module']. '::'. $aimx['code']. '_create_header', ['aimx' => $aimx])

        @include($aimx['module']. '::'. $aimx['code']. '_create_overview' , ['aimx' => $aimx])
        
    </div>

</x-app-layout>
