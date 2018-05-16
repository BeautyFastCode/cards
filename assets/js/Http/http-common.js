/**
 *
 */
import axios from 'axios';
import { API_HOST, API_PATH } from '../Config/_entrypoint';

/**
 *
 */
const baseURL = API_HOST + API_PATH;

/**
 *
 *
 */
export const HTTP = axios.create({
    baseURL: baseURL,
});
