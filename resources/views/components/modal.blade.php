<div id="actionModal"
     class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50 hidden"
     style="display: none;">
    <div class="bg-[var(--main-color)] rounded-lg p-6 w-96 max-w-full">
        <h2 class="text-lg font-semibold mb-4" id="modalTitle">Confirm Action</h2>
        <p class="mb-6" id="modalMessage">Are you sure you want to proceed?</p>
        <form id="actionForm" method="POST">
            @csrf
            <div class="flex justify-end space-x-3">
                <button type="button" id="cancelActionBtn" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-[var(--delete-color)] text-white rounded hover:bg-opacity-80">Confirm</button>
            </div>
        </form>
    </div>
</div>

<style>
    #actionModal {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        height: 100vh;
        width: 100vw;
        background-color: rgba(0,0,0,0.5);
        z-index: 9999;
    }
</style>
