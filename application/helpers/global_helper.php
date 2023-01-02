<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('get_settings')) {
    function get_settings($key = '')
    {
        $CI = &get_instance();

        $row = $CI->db
            ->select('content')
            ->where('key', $key)
            ->get('settings')
            ->row();

        return $row->content;
    }
}

if (!function_exists('update_settings')) {
    function update_settings($key, $new_content)
    {
        $CI = init();

        $CI->db->where('key', $key)
            ->update('settings', array('content' => $new_content));
    }
}

if (!function_exists('get_store_name')) {
    function get_store_name()
    {
        return get_settings('store_name');
    }
}


if (!function_exists('get_admin_image')) {
    function get_admin_image()
    {
        $id = get_current_user_id();
        $CI = init();
        $data = $CI->db->select('profile_picture')->where('id', $id)->get('users')->row();
        $profile_picture = $data->profile_picture;
        if (file_exists('assets/uploads/users/' . $profile_picture) and $profile_picture != NULL)
            $file = $profile_picture;
        else
            $file = 'admin.png';

        return base_url('assets/uploads/users/' . $file);
    }
}

if (!function_exists('get_admin_name')) {
    function get_admin_name()
    {
        $data = user_data();

        return $data->name;
    }
}

if (!function_exists('get_user_name')) {
    function get_user_name()
    {
        $CI = init();
        $id = get_current_user_id();
        $user = $CI->db->query("SELECT * FROM user WHERE id = '$id'")->row();
        return $user->nama;
    }
}

if (!function_exists('get_notif_op')) {
    function get_notif_op($data)
    {
        switch ($data) {
            case 1:
                return ' <span class="badge badge-danger" style="font-size:15px;">Belum Dibaca</span>';
                break;
            case 2:
                return  '<span class="badge badge-success" style="font-size:15px;">Telah Dibaca</span>';
                break;
        }
    }
}

if (!function_exists('get_tipe_am')) {
    function get_tipe_am($data)
    {
        switch ($data) {
            case 'Segera':
                return '<span class="badge badge-danger" style="font-size:12px;">Segera</span>';
                break;
            case 'Tidak':
                return  '<span class="badge badge-info" style="font-size:12px;">Tidak</span>';
                break;
        }
    }
}

if (!function_exists('get_user_image')) {
    function get_user_image()
    {
        $CI = init();
        $id = get_current_user_id();

        $user = $CI->db->query("
            SELECT u.*, c.*
            FROM users u
            JOIN customers c
            ON c.user_id = u.id
            WHERE u.id = '$id'
        ")->row();

        $picture = $user->profile_picture;
        $file = './assets/uploads/users/' . $picture;
        if (file_exists($file) and $picture != NULL) {
            $picture_name = $picture;
        } else {
            $picture_name = 'admin.png';
        }

        return base_url('assets/uploads/users/' . $picture_name);
    }
}

if (!function_exists('get_store_logo')) {
    function get_store_logo()
    {
        $file = get_settings('store_logo');
        return base_url('assets/uploads/sites/' . $file);
    }
}

if (!function_exists('get_formatted_date')) {
    function get_formatted_date($source_date)
    {
        $d = strtotime($source_date);

        $year = date('Y', $d);
        $month = date('n', $d);
        $day = date('d', $d);
        $day_name = date('D', $d);

        $day_names = array(
            'Sun' => 'Minggu',
            'Mon' => 'Senin',
            'Tue' => 'Selasa',
            'Wed' => 'Rabu',
            'Thu' => 'Kamis',
            'Fri' => 'Jum\'at',
            'Sat' => 'Sabtu'
        );
        $month_names = array(
            '1' => 'Januari',
            '2' => 'Februari',
            '3' => 'Maret',
            '4' => 'April',
            '5' => 'Mei',
            '6' => 'Juni',
            '7' => 'Juli',
            '8' => 'Agustus',
            '9' => 'September',
            '10' => 'November',
            '11' => 'Oktober',
            '12' => 'Desember'
        );
        $day_name = $day_names[$day_name];
        $month_name = $month_names[$month];

        $date = "$day_name, $day $month_name $year";

        return $date;
    }
}

if (!function_exists('format_rupiah')) {
    function format_rupiah($rp)
    {
        return number_format($rp, 2, ',', '.');
    }
}

if (!function_exists('create_product_sku')) {
    function create_product_sku($name, $category, $price, $stock)
    {
        $name = create_acronym($name);
        $category = create_acronym($category);
        $price = create_acronym($price);
        $stock = $stock;
        $key = substr(time(), -3);

        $sku =  $name . $category . $price . $stock . $key;
        return $sku;
    }
}

if (!function_exists('create_acronym')) {
    function create_acronym($words)
    {
        $words = explode(' ', $words);
        $acronym = '';

        foreach ($words as $word) {
            $acronym .= $word[0];
        }

        $acronym = strtoupper($acronym);

        return $acronym;
    }
}

if (!function_exists('count_percent_discount')) {
    function count_percent_discount($discount, $from, $num = 1)
    {
        $count = ($discount / $from) * 100;
        $count = number_format($count, $num);

        return $count;
    }
}

if (!function_exists('get_product_image')) {
    function get_product_image($id)
    {
        $CI = init();
        $CI->load->model('product_model');

        $data = $CI->product_model->product_data($id);
        $picture_name = $data->picture_name;

        if (!$picture_name)
            $picture_name = 'default.jpg';

        $file = './assets/uploads/products/' . $picture_name;

        return base_url('assets/uploads/products/' . $picture_name);
    }
}



if (!function_exists('get_order_status')) {
    function get_order_status($status, $payment)
    {
        if ($payment == 1) {
            // Bank
            if ($status == 1)
                return 'Menunggu pembayaran';
            elseif ($status == 2)
                return 'Dalam proses';
            elseif ($status == 3)
                return 'Dalam pengiriman';
            elseif ($status == 4)
                return 'Selesai';
            elseif ($status == 5)
                return 'Dibatalkan';
        } elseif ($payment == 2) {
            //COD
            if ($status == 1)
                return 'Dalam proses';
            elseif ($status == 2)
                return 'Dalam pengiriman';
            elseif ($status == 3)
                return 'Selesai';
            elseif ($status == 4)
                return 'Dibatalkan';
        } elseif ($payment == 3) {
            if ($status == 1) {
                return 'Menunggu pembayaran';
            } elseif ($status == 2) {
                return 'Dalam proses';
            } elseif ($status == 3) {
                return 'Dalam pengiriman';
            } elseif ($status == 4) {
                return 'Selesai';
            } elseif ($status == 5) {
                return 'Dibatalkan';
            }
        }
    }
}

if (!function_exists('get_payment_status')) {
    function get_payment_status($status)
    {
        if ($status == 1)
            return 'Menunggu konfirmasi';
        else if ($status == 2)
            return 'Berhasil dikonfirmasi';
        else if ($status == 3)
            return 'Pembayaran Dibatalkan';
        else if ($status == 0)
            return 'Menunggu Pembayaran';
    }
}

if (!function_exists('generate_kode')) {
    function generate_kode($jenis, $data)
    {
        if ($jenis == 'perbaikan') {
            return "PRB" . rand(1, 9999) . $data;
        } else if ($jenis == 'jadwal') {
            return "JDWL" . rand(1, 9999) . $data;
        }
    }
}


if (!function_exists('status_mt')) {
    function status_mt($data)
    {
        switch ($data) {
            case 1:
                return "Open";
                break;
            case 2:
                return "Waiting";
                break;
            case 3:
                return "Close";
                break;
        }
    }
}

if (!function_exists('status_selesai')) {
    function status_selesai($data)
    {
        if ($data == "-") {
            return "Belum Selesai";
        } else {
            return $data;
        }
    }
}
if (!function_exists('get_persen')) {
    function get_persen($data1, $data2)
    {
        $newdata1 = $data1 * 100;
        $newdata2 = $data2 * 100;
        $persen = 0;
        if ($newdata2 > $newdata1) {
            $persen = ceil((($newdata2 - $newdata1) / $newdata1) * 100);
        } else {
            $persen = ceil((($newdata2 - $newdata1) / $newdata2) * 100);
        }
        return $persen;
    }
}
if (!function_exists('get_income')) {
    function get_income($data1, $data2)
    {
        $newdata1 = $data1;
        $newdata2 = $data2;
        $persen = 0;
        if ($newdata2 > $newdata1) {
            $persen = (($newdata2 - $newdata1) / $newdata1) * 100;
        } else {
            $persen = (($newdata2 - $newdata1) / $newdata2) * 100;
        }
        return number_format($persen, 1);
    }
}

if (!function_exists('get_income_perday')) {
    function get_income_perday($data = array())
    {
        $newdata1 = $data[0]->total_payment;
        $newdata2 = $data[1]->total_payment;
        if (isset($data[0]->status) or isset($data[1]->status)) {
            if ($data[1]->status == '2hari') {
                $newdata2 = $data[0]->total_payment;
                $newdata1 = $data[1]->total_payment;
            }
        }

        if ($newdata1 == 0 && $newdata2 == 0 || $newdata1 == $newdata2) {
            return '<p class="mt-2 mb-0 text-sm" style="display:inline-block">
            <span class="text-nowrap">Pendapatan Sama</span>
            <span class="text-nowrap">Dengan Hari Sebelumnya</span>
          </p>';
        }
        $persen = 0;
        if ($newdata2 > $newdata1) {
            $persen = $newdata2 - $newdata1;
            return '<p class="mt-2 mb-0 text-sm" style="display:inline-block">
            <span class="text-success mr-2"><i class="fa fa-arrow-up"></i></span>
            <span class="text-nowrap">Pendapatan Menaik Rp.' . format_rupiah($persen) . '</span>
            <span class="text-nowrap ml-4">Dengan Hari Sebelumnya</span>
          </p>';
        } else if ($newdata2 < $newdata1) {
            $persen = $newdata1 - $newdata2;
            return '<p class="mt-2 mb-0 text-sm" style="display:inline-block">
            <span class="text-danger mr-2"><i class="fa fa-arrow-down"></i></span>
            <span class="text-nowrap">Pendapatan Menurun Rp.' . format_rupiah($persen) . '</span>
            <span class="text-nowrap ml-4">Dengan Hari Sebelumnya</span>
          </p>';
        }
    }
}

if (!function_exists('get_order_perday')) {
    function get_order_perday($data = array())
    {
        $newdata1 = $data[0]->total_order;
        $newdata2 = $data[1]->total_order;
        if (isset($data[0]->status) or isset($data[1]->status)) {
            if ($data[1]->status == '2hari') {
                $newdata2 = $data[0]->total_order;
                $newdata1 = $data[1]->total_order;
            }
        }

        if ($newdata1 == 0 && $newdata2 == 0 || $newdata1 == $newdata2) {
            return '<p class="mt-2 mb-0 text-sm" style="display:inline-block">
            <span class="text-nowrap">Orderan Sama</span>
            <br>
            <span class="text-nowrap">Dengan Hari Sebelumnya</span>
          </p>';
        }
        $persen = 0;
        if ($newdata2 > $newdata1) {
            $persen = $newdata2 - $newdata1;
            return '<p class="mt-2 mb-0 text-sm" style="display:inline-block">
            <span class="text-success mr-2"><i class="fa fa-arrow-up"></i></span>
            <span class="text-nowrap">Orderan Meningkat Sebanyak ' . $persen . '</span>
            <span class="text-nowrap ml-4">Dengan Hari Sebelumnya</span>
          </p>';
        } else if ($newdata2 < $newdata1) {
            $persen = $newdata1 - $newdata2;
            return '<p class="mt-2 mb-0 text-sm" style="display:inline-block">
            <span class="text-danger mr-2"><i class="fa fa-arrow-down"></i></span>
            <span class="text-nowrap">Orderan Menurun Sebanyak ' . $persen . '</span>
            <span class="text-nowrap ml-4">Dengan Hari Sebelumnya</span>
          </p>';
        }
    }
}
if (!function_exists('get_income_perday_total')) {
    function get_income_perday_total($data = array())
    {
        $newdata1 = $data[0]->total_payment;
        $newdata2 = $data[1]->total_payment;
        if (isset($data[0]->status) or isset($data[1]->status)) {
            if ($data[1]->status == '2hari') {
                $newdata2 = $data[0]->total_payment;
                $newdata1 = $data[1]->total_payment;
            }
        }
        return $newdata2;
    }
}
if (!function_exists('get_order_perday_total')) {
    function get_order_perday_total($data = array())
    {
        $newdata1 = $data[0]->total_order;
        $newdata2 = $data[1]->total_order;
        if (isset($data[0]->status) or isset($data[1]->status)) {
            if ($data[1]->status == '2hari') {
                $newdata2 = $data[0]->total_order;
                $newdata1 = $data[1]->total_order;
            }
        }
        return $newdata2;
    }
}


if (!function_exists('get_notif_status')) {
    function get_notif_status($status)
    {
        if ($status == 1)
            return '<span class="badge badge-pill badge-danger">Pending</span>';
        else if ($status == 2)
            return '<span class="badge badge-pill badge-success">Berhasil</span>';
        else if ($status == 3)
            return '<span class="badge badge-pill badge-danger">Dibatalkan</span>';
    }
}
if (!function_exists('get_notif_status_admin')) {
    function get_notif_status_admin($status)
    {

        if ($status == 2)
            return '<span class="badge badge-pill badge-success">Perlu Diproses</span>';
        else if ($status == 1)
            return '<span class="badge badge-pill badge-danger">Menunggu Konfirmasi</span>';
    }
}

if (!function_exists('get_contact_status')) {
    function get_contact_status($status)
    {
        if ($status == 1)
            return 'Belum dibaca';
        else if ($status == 2)
            return 'Sudah dibaca';
        else if ($status == 3)
            return 'Sudah dibalas';
    }
}


if (!function_exists('get_rating')) {
    function get_rating($hasil, $total)
    {
        if ($hasil == 0) {
            return '0.0';
        }
        $rating = $hasil / $total;
        $res = (is_float($rating)) ? substr($rating, 0, 3) : $rating . '0';
        return $res;
    }
}
if (!function_exists('get_star_user')) {
    function get_star_user($star)
    {
        switch ($star) {
            case 1:
                return '<p class="text-center" style="color:#D1D100;">
                <i class="fa fa-star"></i>
                </p>';
                break;
            case 2:
                return '<p class="text-center" style="color:#D1D100;">
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                </p>';
                break;
            case 3:
                return '<p class="text-center" style="color:#D1D100;">
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                </p>';
                break;
            case 4:
                return '<p class="text-center" style="color:#D1D100;">
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                </p>';
                break;
            case 5:
                return '<p class="text-center" style="color:#D1D100;">
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                </p>';
                break;
        }
    }
}
if (!function_exists('get_star_review')) {
    function get_star_review($hasil, $total)
    {
        if ($hasil == 0) {
            return '<span class="ion-ios-star-outline"></span>
            <span class="ion-ios-star-outline"></span>
            <span class="ion-ios-star-outline"></span>
            <span class="ion-ios-star-outline"></span>
            <span class="ion-ios-star-outline"></span>';
        }
        $res = $hasil / $total;

        switch ($res) {
            case ($res < 1 && $res < 0.5):
                return '
                <span class="ion-ios-star-outline"></span>
                <span class="ion-ios-star-outline"></span>
                <span class="ion-ios-star-outline"></span>
                <span class="ion-ios-star-outline"></span>
                <span class="ion-ios-star-outline"></span>';
                break;
            case ($res >= 0.5 && $res < 1):
                return '
                <span class="ion-ios-star-half"></span>
                <span class="ion-ios-star-outline"></span>
                <span class="ion-ios-star-outline"></span>
                <span class="ion-ios-star-outline"></span>
                <span class="ion-ios-star-outline"></span>';
                break;
            case ($res >= 1 && $res < 1.5):
                return '
                <span class="ion-ios-star"></span>
                <span class="ion-ios-star-outline"></span>
                <span class="ion-ios-star-outline"></span>
                <span class="ion-ios-star-outline"></span>
                <span class="ion-ios-star-outline"></span>';
                break;
            case ($res >= 1.5 && $res < 2):
                return '
                <span class="ion-ios-star"></span>
                <span class="ion-ios-star-half"></span>
                <span class="ion-ios-star-outline"></span>
                <span class="ion-ios-star-outline"></span>
                <span class="ion-ios-star-outline"></span>';
                break;
            case ($res >= 2 && $res < 2.5):
                return '
                <span class="ion-ios-star"></span>
                <span class="ion-ios-star"></span>
                <span class="ion-ios-star-outline"></span>
                <span class="ion-ios-star-outline"></span>
                <span class="ion-ios-star-outline"></span>';
                break;
            case ($res >= 2.5 && $res < 3):
                return '
                <span class="ion-ios-star"></span>
                <span class="ion-ios-star"></span>
                <span class="ion-ios-star-half"></span>
                <span class="ion-ios-star-outline"></span>
                <span class="ion-ios-star-outline"></span>';
                break;
            case ($res >= 3 && $res < 3.5):
                return '
                <span class="ion-ios-star"></span>
                <span class="ion-ios-star"></span>
                <span class="ion-ios-star"></span>
                <span class="ion-ios-star-outline"></span>
                <span class="ion-ios-star-outline"></span>';
                break;
            case ($res >= 3.5 && $res < 4):
                return '
                <span class="ion-ios-star"></span>
                <span class="ion-ios-star"></span>
                <span class="ion-ios-star"></span>
                <span class="ion-ios-star-half"></span>
                <span class="ion-ios-star-outline"></span>';
                break;
            case ($res >= 4 && $res < 4.5):
                return '
                <span class="ion-ios-star"></span>
                <span class="ion-ios-star"></span>
                <span class="ion-ios-star"></span>
                <span class="ion-ios-star"></span>
                <span class="ion-ios-star-outline"></span>';
                break;
            case ($res >= 4.5 && $res < 5):
                return '
                <span class="ion-ios-star"></span>
                <span class="ion-ios-star"></span>
                <span class="ion-ios-star"></span>
                <span class="ion-ios-star"></span>
                <span class="ion-ios-star-half"></span>';
                break;
            case ($res == 5):
                return '
                <span class="ion-ios-star"></span>
                <span class="ion-ios-star"></span>
                <span class="ion-ios-star"></span>
                <span class="ion-ios-star"></span>
                <span class="ion-ios-star"></span>';
                break;
        }
    }
}
if (!function_exists('is_read')) {
    function is_read($status)
    {
        if ($status == 0)
            return '<span class="badge badge-pill badge-info">Belum dibaca</span>';
        else if ($status == 1)
            return '<span class="badge badge-pill badge-info">Sudah dibaca</span>';
    }
}

if (!function_exists('status')) {
    function status($status, $data, $mesin)
    {
        switch ($status) {
            case 1:
                echo '
                <select class="btn btn-danger status" style="font-size:11px;"  data-id="' . $data . '" data-mesin="' . $mesin . '">
                <option value="1" selected style="display:none">Open</option>
                <option value="2" style="font-size:13px;">Waiting</option>
                <option value="3" style="font-size:13px;">Close</option>
              </select>';
                break;
            case 2:
                echo '
                <select class="btn btn-warning status" style="font-size:11px;"  data-id="' . $data . '" data-mesin="' . $mesin . '">
                <option value="2" selected style="display:none">Waiting</option>
                <option value="1" style="font-size:13px;">Open</option>
                <option value="3" style="font-size:13px;">Close</option>
              </select>';
                break;
            case 3:
                echo '
                <select class="btn btn-success status" style="font-size:11px;"  data-id="' . $data . '" data-mesin="' . $mesin . '">
                <option value="3" selected style="display:none">Close</option>
                  </select>';
                break;
        }
    }
}



if (!function_exists('get_month')) {
    function get_month($mo)
    {
        $months = array(
            '1' => 'Januari',
            '2' => 'Februari',
            '3' => 'Maret',
            '4' => 'April',
            '5' => 'Mei',
            '6' => 'Juni',
            '7' => 'Juli',
            '8' => 'Agustus',
            '9' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        );

        return $months[$mo];
    }
}
