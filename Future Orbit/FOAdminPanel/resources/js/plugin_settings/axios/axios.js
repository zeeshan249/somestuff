// This file contains axios settings
import axios from 'axios'

const baseURL = process.env.MIX_BASE_URL + "api/";

export default axios.create({
    baseURL

  // You can add your headers here
})
