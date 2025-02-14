window.onload = function()
{
    const path = window.location.pathname.split("/");

    switch(path[1])
    {
        case "":
        {
            loadPage("home");
            break;
        }
        case "enrolled":
        {
            loadPage("enrolled");
            break;
        }
        case "archive":
        {
            loadPage("archive");
            break;
        }
        default:
        {
            loadPage("home");
            break;
        }
    }

    document.querySelectorAll(".menu__item").forEach((item) =>
    {
        item.addEventListener("click", function()
        {
            const path = item.getAttribute("value");
            loadPage(path);
            if(path == "home")
            {
                window.history.pushState("", "", "/");
                return;
            }

            window.history.pushState("", "", path);
        });
    });

    function loadPage($path)
    {
        if($path == "") return;

        const container = document.getElementById("container");

        const request = new XMLHttpRequest();
        request.open("GET", "/MINORPROJECT/new_dashboard/pages/" + $path + ".php");
        request.send();
        request.onload = function()
        {
            if(request.status == 200)
            {
                container.innerHTML = request.responseText;
                document.title = $path;
            }
        }
    }
}