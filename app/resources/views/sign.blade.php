@extends('layout.base')

@section('content')


    <!-- Modal -->
    <div class="modal fade" id="pdfModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Signature du pdf</h5>
                </div>
                <div class="text-center">
                    <br>
                    <h2>Bonjour {{$signatory->firstname}}</h2>
                    <p>Veuillez lire le PDF jusqu'à la dernière page pour pouvoir signer</p>

                    <span>Page: <span id="page_num"></span> / <span id="page_count"></span></span>
                    <br>
                    <button id="prev" class="btn btn-tiny btn-default">Previous</button>
                    <button id="next" class="btn btn-tiny btn-default">Next</button>
                </div>
                <canvas id="the-canvas"></canvas>
                <div class="modal-footer">
                    <button type="button" id="close-modal-btn" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div id="error"></div>

    <div id="signature-pad" class="signature-pad text-center">
        <h2 class="description">Merci d'apposer votre signature dans le cadre ci-dessous</h2>
        <div class="signature-pad--body">
            <canvas style="border: 1px solid black;width: 200px; height: 200px"></canvas>
        </div>
        <div class="signature-pad--footer">
            <div class="signature-pad--actions">
                <button id="save" class="btn btn-tiny  btn-default">Signer</button>
                <button id="clear" class="btn btn-tiny  btn-danger">Effacer</button>
            </div>
        </div>
    </div>

    {{--JQUERY--}}
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

    {{--SIGNATURE--}}
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

    {{--PDF DISPLAY--}}
    <script src="//mozilla.github.io/pdf.js/build/pdf.js"></script>

    <script type="text/javascript">
      // If absolute URL from the remote server is provided, configure the CORS
      // header on that server.
      var url = "{{config('app.url') . '/storage/pdf/' . $signatory->rds->file_name . '.pdf'}}";

      // The workerSrc property shall be specified.
      pdfjsLib.GlobalWorkerOptions.workerSrc = '//mozilla.github.io/pdf.js/build/pdf.worker.js';

      var pdfDoc = null,
        pageNum = 1,
        pageRendering = false,
        pageNumPending = null,
        scale = 0.8,
        canvas = document.getElementById('the-canvas'),
        ctx = canvas.getContext('2d');

      /**
       * Get page info from document, resize canvas accordingly, and render page.
       * @param num Page number.
       */
      function renderPage(num) {
        pageRendering = true;
        // Using promise to fetch the page
        pdfDoc.getPage(num).then(function(page) {
          var viewport = page.getViewport(scale);
          canvas.height = viewport.height;
          canvas.width = viewport.width;

          // Render PDF page into canvas context
          var renderContext = {
            canvasContext: ctx,
            viewport: viewport
          };
          var renderTask = page.render(renderContext);

          // Wait for rendering to finish
          renderTask.promise.then(function() {
            pageRendering = false;
            if (pageNumPending !== null) {
              // New page rendering is pending
              renderPage(pageNumPending);
              pageNumPending = null;
            }
          });
        });

        // Update page counters
        document.getElementById('page_num').textContent = num;
      }

      /**
       * If another page rendering in progress, waits until the rendering is
       * finised. Otherwise, executes rendering immediately.
       */
      function queueRenderPage(num) {
        if (pageRendering) {
          pageNumPending = num;
        } else {
          renderPage(num);
        }
      }

      /**
       * Displays previous page.
       */
      function onPrevPage() {
        if (pageNum <= 1) {
          return;
        }
        pageNum--;
        queueRenderPage(pageNum);
      }
      document.getElementById('prev').addEventListener('click', onPrevPage);

      /**
       * Displays next page.
       */
      function onNextPage() {
        if(pageNum == pdfDoc.numPages-1) {
          $('#close-modal-btn').show();
        }
        if (pageNum >= pdfDoc.numPages) {
          return;
        }
        pageNum++;
        queueRenderPage(pageNum);
      }
      document.getElementById('next').addEventListener('click', onNextPage);

      /**
       * Asynchronously downloads PDF.
       */
      pdfjsLib.getDocument(url).then(function(pdfDoc_) {
        pdfDoc = pdfDoc_;
        document.getElementById('page_count').textContent = pdfDoc.numPages;

        // Initial/first page rendering
        renderPage(pageNum);
      });

    </script>

    {{--DISPLAY MODAL--}}
    <script type="text/javascript">
        $(window).on('load',function(){
          $('#close-modal-btn').hide();
          $('#pdfModal').modal({backdrop: 'static', keyboard: false});
        });
    </script>

@endsection