let navlinks = document.querySelector(".nav-links");
        function onToggleMenu() {
            let menu = document.querySelector(".menu");
            if(menu.src.endsWith("menu.png")){
                menu.src = "/src/img/close.png";
            }else{
                menu.src = "/src/img/menu.png";
            }
            navlinks.classList.toggle('top-[60px]');
        }