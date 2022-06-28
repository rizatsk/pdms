<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2017, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2017, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

// edit validation 
$lang['form_validation_required'] = '{field} wajib diisi.';
$lang['form_validation_isset'] = '{field} harus memiliki nilai.'; // teman-teman bisa menganti semua validasi berikutnya menjadi bhs indonseia
$lang['form_validation_valid_email'] = '{field} field menggunakan alamat email yang benar.';
$lang['form_validation_valid_emails'] = 'Kolom {field} harus berisi semua alamat email yang valid.';
$lang['form_validation_valid_url'] = 'Kolom {field} harus berisi URL yang valid.';
$lang['form_validation_valid_ip'] = 'Kolom {field} harus berisi IP yang valid.';
$lang['form_validation_min_length'] = '{field} panjangnya minimal harus {param} karakter.';
$lang['form_validation_max_length'] = '{field} panjangnya maksimal {param} karakter.';
$lang['form_validation_exact_length'] = 'Panjang Kolom {field} harus persis {param} karakter.';
$lang['form_validation_alpha'] = 'Kolom {field} hanya boleh berisi karakter alfabet.';
$lang['form_validation_alpha_numeric'] = 'Kolom {field} hanya boleh berisi karakter alfanumerik.';
$lang['form_validation_alpha_numeric_spaces'] = 'Kolom {field} hanya boleh berisi karakter alfanumerik dan spasi.';
$lang['form_validation_alpha_dash'] = 'Kolom {field} hanya boleh berisi karakter alfanumerik, garis bawah, dan tanda hubung.';
$lang['form_validation_numeric'] = '{field} kolom harus berisi angka.';
$lang['form_validation_is_numeric'] = 'Kolom {field} hanya boleh berisi karakter numerik.';
$lang['form_validation_integer'] = 'Kolom {field} harus berisi bilangan bulat.';
$lang['form_validation_regex_match'] = 'Format {field} tidak benar.';
$lang['form_validation_matches'] = '{field} tidak cocok dengan {param}.';
$lang['form_validation_differs'] = 'Kolom {field} harus berbeda dari Kolom {param}.';
$lang['form_validation_is_unique'] = '{field} sudah digunakan.';
$lang['form_validation_is_natural'] = 'Kolom {field} hanya boleh berisi angka.';
$lang['form_validation_is_natural_no_zero'] = 'Kolom {field} hanya boleh berisi angka dan harus lebih besar dari nol.';
$lang['form_validation_decimal'] = 'Kolom {field} harus berisi angka desimal.';
$lang['form_validation_less_than'] = 'Kolom {field} harus berisi angka kurang dari {param}.';
$lang['form_validation_less_than_equal_to'] = 'Kolom {field} harus berisi angka yang kurang dari atau sama dengan {param}.';
$lang['form_validation_greater_than'] = 'Kolom {field} harus berisi angka yang lebih besar dari {param}.';
$lang['form_validation_greater_than_equal_to'] = 'Kolom {field} harus berisi angka yang lebih besar atau sama dengan {param}.';
$lang['form_validation_error_message_not_set'] = 'Tidak dapat mengakses pesan kesalahan yang sesuai dengan nama Kolom Anda {field}.';
$lang['form_validation_in_list'] = 'Kolom {field} harus salah satu dari: {param}.';