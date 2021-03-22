<main
    class="mx-auto max-w-4xl bg-gray-200 h-screen"
    x-data="{ 'isDialogOpen': false }"
    @keydown.escape="isDialogOpen = false"
>
    <nav class="p-4 bg-indigo-700 text-indigo-100">
        <div>Modal Dialog</div>
        <div class="text-xs text-indigo-400 font-thin">Alpine.js + TailwindCSS</div>
    </nav>

    <section class="flex flex-wrap p-4">

        <button type="button" class="border p-2 bg-white hover:border-gray-500" @click="isDialogOpen = true">Open modal</button>

        <!-- overlay -->
        <div
            class="overflow-auto"
            style="background-color: rgba(0,0,0,0.5)"
            x-show="isDialogOpen"
            :class="{ 'absolute inset-0 z-10 flex items-start justify-center': isDialogOpen }"
        >
            <!-- dialog -->
            <div
                class="bg-white shadow-2xl m-4 sm:m-8"
                x-show="isDialogOpen"
                @click.away="isDialogOpen = false"
            >
                <div class="flex justify-between items-center border-b p-2 text-xl">
                    <h6 class="text-xl font-bold">Simple modal dialog</h6>
                    <button type="button" @click="isDialogOpen = false">✖</button>
                </div>
                <div class="p-2">
                    <!-- content -->
                    <h4 class="font-bold">Built with Alpine.js + Tailwind CSS</h4>
                    <aside class="max-w-lg mt-4 p-4 bg-yellow-100 border border-yellow-500">
                        <p>⚠ If you want to scope this modal to your entire app, you should apply the following directives to the &lt;body&gt; tag instead of &lt;main&gt; like I did here. Codepen doesn't seem to allow anything other than "class" in the &lt;body&gt; tag</p>
                        <pre class="my-4">
x-data="{ 'isDialogOpen': false }"
@keydown.escape="isDialogOpen = false"
              </pre>
                        <p>This should allow ESC to work even after the button that opens the modal loses focus.</p>
                    </aside>
                    <ul class="bg-gray-100 border m-8 px-4">
                        <li class="my-4">✅ Click ✖ to close</li>
                        <li class="my-4">✅ Click the overlay to close</li>
                        <li class="my-4">✅ Press ESC to close</li>
                    </ul>
                </div>
            </div><!-- /dialog -->
        </div><!-- /overlay -->

    </section>
</main>
