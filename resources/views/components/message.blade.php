<style>
    .toast {
        background-color: #ffffff;
    }

    .toast-header {
        border-bottom: none;
    }

    .toast.position-relative.overflow-hidden {
        border-left: 4px solid #0d6efd;
    }

    .toast .progress1 {
        position: absolute;
        bottom: 0;
        left: 0;
        height: 3px;
        width: 100%;
        background: #ddd;
    }

    .toast .progress1:before {
        content: "";
        position: absolute;
        bottom: 0;
        right: 0;
        height: 100%;
        width: 100%;
        background-color: var(--progress-color, #13900a);
        /* Default color */
    }

    .progress1:before {
        animation: progress 5s linear forwards;
    }

    #toastBody {
        font-size: 16px;
        margin-top: 9px;
        margin-bottom: 9px;
    }

    .toast-header {
        border-bottom: none !important;
    }

    @keyframes progress {
        100% {
            right: 100%;
        }
    }
</style>

<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="liveToast" class="toast position-relative overflow-hidden" role="alert" aria-live="assertive"
        aria-atomic="true">
        <div id="toastHeader" class="toast-header"> <!-- Default Color -->
            <i id="toastIcon" class="fa-solid fa-circle-check fs-5" style="color: #13900a"></i>
            <h5 id="toastTitle" class="me-auto mx-2 mb-0 pb-0" style="font-size: 18px">
                Success
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>

        <div id="toastBody" class="toast-body pt-0">Done</div>
        <div class="progress1">
            <span></span> <!-- 🔹 Added for dynamic color change -->
        </div>
    </div>
</div>
