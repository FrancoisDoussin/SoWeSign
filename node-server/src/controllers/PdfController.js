import PDFParser from 'pdf2json'

export default class PdfController {
  constructor() {
    this.pdfParser = new PDFParser()
  }

  index(req, res) {
    return res.json({'message': 'Welcome'})
  }

  pdf(req, res) {
    this.pdfParser.loadPDF(req.file.path)

    this.pdfParser.on("pdfParser_dataError", errData => {
      console.error('error', errData)

      return res.json({'Message': 'Error loading PDF file'})
    })

    this.pdfParser.on("pdfParser_dataReady", pdfData => {
      const pages = pdfData.formImage.Pages

      const data = [];

      const regexp = /^(%23)(SIGN)(.*)(%23)$/

      pages.forEach(page => {
        page.Texts.forEach(text => {
          if(text.R[0].T.match(regexp)) {
            data.push(text)
          }
        })
      })

      return res.json({
        'Message': 'PDF parsed successfully',
        'Data': data
      })
    })
  }
}