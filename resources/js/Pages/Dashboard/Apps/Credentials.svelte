<script>
    import Dashboard from "../../../Components/Layouts/Dashboard.svelte"
    import AlertModal from "../../../Components/Inputs/AlertModal.svelte"

    export let app;

    let regenerateModal = false;

    let regenModelText = {
        heading: 'Regenerate Credentials',
        body: 'Are you sure you want to regenerate the credentails for this app? This will break anything using the existing keys...',
        button: 'Regenerate'
    }
</script>

<svelte:head>
  <title>Credentials - {app.title} | ISoket</title>
</svelte:head>

<Dashboard items="apps" page="credentials" appId={app.appId} appTitle={app.title}>
    <AlertModal endpoint={'/apps/' + app.appId + '/regenerate-credentials'} text={regenModelText} bind:modalOpen={regenerateModal} />

    <div class="relative max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
        <div class="grow mx-auto rounded-lg bg-white shadow-lg border border-gray-100">
            <div on:click={() => regenerateModal = true} class="h-1/10 cursor-pointer transition duration-200 text-center hover:bg-gray-50 active:bg-gray-100 border-b-2 border-gray-100 py-2">
                    <div class="my-auto">
                        Regenerate Keys
                    </div>
                </div>
                <div class="h-9/10">
                <div class="h-1/3 flex flex-col border-b border-gray-100 p-6 text-center">
                    <dd class="order-1 text-2xl font-extrabold text-indigo-600">App ID</dd>
                    <dt class="order-2 mt-2 text-lg leading-6 font-medium text-gray-500">{app.appId}</dt>
                </div>
                <div class="h-1/3 flex flex-col border-t border-b border-gray-100 p-6 text-center">
                    <dd class="order-1 text-2xl font-extrabold text-indigo-600">App Key</dd>
                    <dt class="order-2 mt-2 text-lg leading-6 font-medium text-gray-500">{app.appKey}</dt>
                </div>
                <div class="h-1/3 flex flex-col border-t border-gray-100 p-6 text-center">
                    <dd class="order-1 text-2xl font-extrabold text-indigo-600">App Secret</dd>
                    <dt class="order-2 mt-2 text-lg leading-6 font-medium text-gray-500">{app.appSecret}</dt>
                </div>
            </div>
        </div> 
    </div>
</Dashboard>