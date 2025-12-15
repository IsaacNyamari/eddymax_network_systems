<div>

    <button wire:click="sendMessage" class="px-4 py-2 rounded bg-green-700">Send Message</button>


</div>
@script
    <script>
        $wire.on('messageSent', (event) => {
            let message = event.name
            console.log(message);

        });
    </script>
@endscript
