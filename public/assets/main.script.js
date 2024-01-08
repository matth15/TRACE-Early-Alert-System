


$(document).ready(function(){

    wrapperToggled();
    subMenu();
});

function subMenu(){
    $('.sub-btn').click(function(){
        $(this).next('.sub-menu').slideToggle({
            duration: 143,
            easing: 'linear'
        });
        $(this).find('.fa-dropdown').toggleClass('rotate');
    });
}

function wrapperToggled(){
    var el = document.getElementById("wrapper");
    var toggleButton = document.getElementById("menu-toggle");
    
    toggleButton.onclick = function() {
        el.classList.toggle("toggled");
    };
    
}
    function showAlert(type = '', msg = '', containerId = '') {
        if (!(type == '' && msg == '' && containerId == '')) {
            var alertHtml = ' <div class=" "> <div id="autoFadeAlert" class=" shadow-sm rounded-0 alert alert-' + type + ' alert-dismissible fade show" role="alert">' +
                msg + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' + '</div> </div>';
    
            $(containerId).html(alertHtml);
        } else {
    
            $('#autoFadeAlert').alert('close');
        }
    }
    
    //auto hide toast function
    function showToast(type, title, body, containerId) {
        var newBody = body;
        var toastBody = `
        <div id="liveToast" class="toast show fade hide w-auto" role="alert" aria-live="assertive" aria-atomic="true">
            <div class=" toast-header">
                <strong class="me-auto">${title} </strong>
                <small></small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body accordion-collapse "> <i class="fa-solid fa-xl fa-circle-check me-1 mb-2" style="color: #1fbd0a;"></i> ${newBody} </div></div>`;
        $(containerId).html(toastBody);
    
    
        setTimeout(function() {
            $('#liveToast').toast('hide');
        }, 6500);
    }


