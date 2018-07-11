@extends('layout.base')

@section('content')
    Salut {{$signatory->firstname}} !

    <iframe src="{{config('app.url') . '/storage' .$signatory->rds->file_path}}" frameborder="0"></iframe>

    <div id="signature-pad" class="signature-pad" style="height: 500px; width: 800px">
        <div class="signature-pad--body">
            <canvas></canvas>
        </div>
        <div class="signature-pad--footer">
            <div class="description">Sign above</div>

            <div class="signature-pad--actions">
                <button id="save">Signer</button>
                <button id="clear">Effacer</button>
            </div>
        </div>
    </div>

    <div id="error"></div>

    <script
            src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>
    <script src="{{asset('storage/js/signature_pad.js')}}"></script>
    <script src="{{asset('storage/js/signature_app.js')}}"></script>

    <script>
      var csrf = "{{csrf_token()}}"
      var appUrl = "{{config('app.url')}}"
      var signatoryId = "{{$signatory->id}}"

      document.querySelector('#save').addEventListener("click", function (event) {
        if (signaturePad.isEmpty()) {
          alert("Please provide a signature first.");
        } else {
          var dataURL = signaturePad.toDataURL();
          var blob = dataURItoBlob(dataURL);

          var fd = new FormData();
          fd.append('_token', csrf)
          fd.append('sign', blob);
          fd.append('signatory_id', signatoryId);
          $.ajax({
            type: 'POST',
            url: appUrl + '/upload',
            data: fd,
            processData: false,
            contentType: false
          }).done(function(data) {
            if (data == 'success') {
              document.location.href=appUrl + '/sign-success'
            } else {
              document.querySelector('#error').innerHTML = 'Une erreur est survenue'
            }
          });
        }
      });

      document.querySelector('#clear').addEventListener("click", function (event) {
        signaturePad.clear()
      });


      function dataURItoBlob(dataURI)
      {
        var byteString = atob(dataURI.split(',')[1]);

        var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0]

        var ab = new ArrayBuffer(byteString.length);
        var ia = new Uint8Array(ab);
        for (var i = 0; i < byteString.length; i++)
        {
          ia[i] = byteString.charCodeAt(i);
        }

        var bb = new Blob([ab], { "type": mimeString });
        return bb;
      }
    </script>
@endsection