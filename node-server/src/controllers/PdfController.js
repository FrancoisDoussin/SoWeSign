import PDFParser from 'pdf2json'

export default class PdfController {
  index(req, res) {
    return res.json({'message': 'Welcome'})
  }

  pdf(req, res) {
    const pdfParser = new PDFParser()

    pdfParser.loadPDF(req.file.path)

    pdfParser.on("pdfParser_dataError", errData => {
      console.error('error', errData)

      return res.json({
        message: 'Error loading PDF file'
      })
    })

    pdfParser.on("pdfParser_dataReady", pdfData => {
      console.log('PDF successfully parsed')

      const data = this._parsePDF(pdfData)

      return res.json({
        message: 'PDF successfully parsed',
        data: data
      })
    })
  }

  _parsePDF(pdfData) {
    const pages = pdfData.formImage.Pages

    const data = [];

    const regexp = /^(%23)(SIGN)(.*)(%23)$/

    for (let i = 0; i < pages.length; i++) {
      pages[i].Texts.forEach(text => {
        if(text.R[0].T.match(regexp)) {
          var match = text.R[0].T.match(regexp)
          text.user_tag = match[3]
          text.page = i+1
          data.push(text)
        }
      })
    }

    return data
  }
}