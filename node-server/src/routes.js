import PdfController from './controllers/PdfController'
import multer from 'multer'

export default class Routes {
  constructor(app) {
    this._app = app
    this._initRoutes()
  }

  _initRoutes() {
    const upload = multer({ dest: 'uploads/' });
    const pdfController = new PdfController()
    /*
     * Basic routes
     */
    this._app.get('/', pdfController.index.bind(pdfController))
    this._app.post('/pdf', upload.single('pdf'), pdfController.pdf.bind(pdfController))
  }
}