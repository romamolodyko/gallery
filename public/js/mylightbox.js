function clickImg(obj) {
    var img = document.getElementById("img");
    var eclipse = document.getElementById("eclipse");
    img.style.display = "block";
    eclipse.style.display = "block";
    var sr = img.style.backgroundImage = "url(http://localhost/gallery/uploads/original/"+obj+")";
    eclipse.onclick = closeImg;
    img.onclick = nextImg(sr);

}

function closeImg()
{
    var img = document.getElementById("img");
    var eclipse = document.getElementById("eclipse");
    img.style.display = "";
    eclipse.style.display = "";
}

function nextImg(sr)
{
    var imgTag = document.getElementsByTagName("IMG");
    var img = document.getElementById("img");
    }



