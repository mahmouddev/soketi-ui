<script>
    import Pusher from 'pusher-js';

    import Button from "../../../Components/Inputs/Button.svelte"
    import Dashboard from "../../../Components/Layouts/Dashboard.svelte"
    import DebugEvent from "../../../Components/Cards/DebugEventCard.svelte"
    import FaSpinner from 'svelte-icons/fa/FaSpinner.svelte'

    export let app;
    export let debugEvents;

    const pusher = new Pusher(app.appKey, {
        // wsHost: process.env.HOST,
        // wsPort: 6001,
        // forceTLS: false,
        // encrypted: true,
        // enabledTransports: ['ws', 'wss'],
        cluster:process.env.MIX_PUSHER_APP_CLUSTER,
        wsHost: process.env.MIX_PUSHER_HOST,
        wsPort: process.env.MIX_PUSHER_PORT,
        wssPort: process.env.MIX_PUSHER_PORT,
        encrypted: true,
        forceTLS: (process.env.MIX_PUSHER_SCHEME ?? 'https') === 'https',
        enabledTransports: ['ws', 'wss'],
    });

    pusher.connection.bind('connected', function() {
    
        console.log('connected !!');
    });
    
    pusher.connection.bind('error', function() {
        
        console.log('error !!')
    });

    const channel = pusher.subscribe('debug-events_' + app['appId']);

    channel.bind("App\\Events\\NewDebugEvents", (data) => {
        
        debugEvents = [...debugEvents, ...data];
    });
</script>

<svelte:head>
  <title>Debug - {app.title} | ISoket</title>
</svelte:head>

<Dashboard items="apps" page="debug" appId={app.appId} appTitle={app.title}>
    <div class="max-w-7xl flex items-center mx-auto px-4 sm:px-6 md:px-8 pb-4">
        <div class="flex grow">
            <div class="flex items-center p-2 text-center">
                <div class="animate-spin text-black h-4 w-4 mr-2">
                    <FaSpinner />
                </div>
                Listening for events...
            </div>
            <div class="ml-auto">
                <Button label="Clear Events" endpoint="/apps/{app.appId}/debug/clear" />
            </div>
       </div>
    </div>

    <div class="max-w-7xl items-center mx-auto px-4 sm:px-6 md:px-8 pb-4">
        <div>
        <div class="flex items-center font-semibold p-2 bg-gray-50 rounded-lg">
            <div class="w-1/5">
                Event
            </div>
            <div class="w-1/3">
                Channel
            </div>
            <div class="w-1/3">
                User ID
            </div>
            <div class="w-1/5">
                Timestamp
            </div>
        </div>
        {#if debugEvents.length != 0}
        <div class="w-full flex flex-col-reverse">
        {#each debugEvents as debugEvent, i}
        <div class="w-full py-2">
            <DebugEvent {debugEvent} />
        </div>
        {/each}
        </div>
        {/if}
    </div>
</Dashboard>
