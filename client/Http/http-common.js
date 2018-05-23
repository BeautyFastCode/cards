
/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

import axios from 'axios';
import { API_HOST, API_PATH } from '../Config/_entrypoint';

/**
 * HTTP configurations.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
const baseURL = API_HOST + API_PATH;

export const HTTP = axios.create({
    baseURL: baseURL,
});
