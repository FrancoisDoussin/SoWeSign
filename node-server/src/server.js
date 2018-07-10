import path from 'path'
import express from 'express'
import bodyParser from 'body-parser'

import Routes from './routes'

export default class Server {
  constructor() {
    // init app server
    this._app = express();

    // set public directory where to put client css an js files
    this._app.use(express.static(path.join(__dirname, '/../public')));

    // parse requests
    this._app.use(bodyParser.json());
    this._app.use(bodyParser.urlencoded({extended: true}));

    // set app port
    this.port = 2440;

    // init routes
    new Routes(this._app);
  }

  run() {
    this._app.listen(this.port, () => console.log(`Server available at http://localhost:${this.port}!`));
  }
}