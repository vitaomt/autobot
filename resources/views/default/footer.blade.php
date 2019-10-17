<script src="{{ asset('resources/views/default/assets/js/app.min.js') }}"></script>
<script>
    if($(document).width() <= 768){
          console.log("sa");
        $("#L1").toggleClass("container-fluid");
        $("#L2").toggleClass("row");
        $("#L3").toggleClass("col-md-2");
       
        $("#L4").toggleClass("col-md-8");
    }
</script>
<script>
    $('#inputGroupFile02').on('change', function() {
        var fileName = $(this).val();
        $(this).next('.custom-file-label').html(fileName);
    })
</script>

<script type="text/javascript">
    function imgClick() {

        $('img.passImage')
            .click(function() {
                // alert($(this).attr('src'))

                imgTarget.src = $(this).attr('src');
                imgTargetview2.src = $(this).attr('src');
                imgTargetInput.value = $(this).attr('src');

                // Album section
                // imgTargetAlbum.src = $(this).attr('src');

                // albumImages.append("<img id=\"imgTargetAlbum\" class=\"imgTarget\" src=\""+$(this).attr('src')+"\">");
                // albumImages.innerHTML+= "<img id=\"imgTargetAlbum\" class=\"imgTarget\" src=\""+$(this).attr('src')+"\">";

            });
    }
    window.addEventListener("load", imgClick);
</script>

<script type="text/javascript">
    function imgClick() {

        $('img.passImageGallery')
            .click(function() {

            albumImages.innerHTML+= "<img id=\""+$(this).attr('id')+"\" class=\"imgTarget\" src=\""+$(this).attr('src')+"\">";
            albumImages.innerHTML+= "<input name=\"album[]\" type=\"hidden\" value=\""+$(this).attr('src')+"\">";

        
            });
    }
    window.addEventListener("load", imgClick);
</script>

<script type="text/javascript">
    function imgClick() {

        $('img.passImageStory')
            .click(function() {
                // alert($(this).attr('src'))

                imgTargetStory.src = $(this).attr('src');
                imgTargetviewStory.src = $(this).attr('src');
                imgTargetInputStory.value = $(this).attr('src');

                // Album section
                // imgTargetAlbum.src = $(this).attr('src');

                // albumImages.append("<img id=\"imgTargetAlbum\" class=\"imgTarget\" src=\""+$(this).attr('src')+"\">");
                // albumImages.innerHTML+= "<img id=\"imgTargetAlbum\" class=\"imgTarget\" src=\""+$(this).attr('src')+"\">";

            });
    }
    window.addEventListener("load", imgClick);
</script>

</body>
</html>