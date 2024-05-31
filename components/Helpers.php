<?php

namespace app\components;

use app\models\AuditHeader;
use app\models\UserLog;
use yii\base\Component;
use Yii;

class Helpers extends Component
{
    public function generateAuditCode($type)
    {
        $max = AuditHeader::find()->where(['like', 'billno', $type . date('ym')])->count('billno');
        if ($max) {
            $max = substr($max, -5);
        }
        return $type . date('ym') . str_pad(($max + 1), 5, '0', STR_PAD_LEFT);
    }

    public function created()
    {
        return [
            'message' => 'create success',
            'code' => 200,
        ];
    }

    function maskPhoneNumber($phoneNumber)
    {
        // Ensure the phone number is at least 10 digits long
        if (strlen($phoneNumber) >= 10) {
            return 'XXXXXX' . substr($phoneNumber, -4);
        } else {
            // Handle cases where the phone number is too short
            return $phoneNumber;
        }
    }

    public function error()
    {
        return [
            'message' => 'Error',
            'code' => 400,
        ];
    }
    public function dateENtoTH($date)
    {
        if (empty($date)) {
            return null;
        }

        $arr = explode("-", $date);
        $dateTh = $arr[2] . "-" . $arr[1] . "-" . ($arr[0] + 543);
        return $dateTh;
    }
    public function dateTHtoEN($date)
    {
        if (empty($date)) {
            return null;
        }

        $arr = explode("-", $date);
        $dateTh = ($arr[2] - 543) . "-" . $arr[1] . "-" . $arr[0];
        return $dateTh;
    }

    public function dateCompare($date) // ฟังก์ชั่นเปรียบเทียบเวลากับปัจจุบัน
    {
        $datetime = date_create($date);
        $dateNow = date_create('now');

        $interval = date_diff($datetime, $dateNow);
        $compareSec = $interval->format('%s');
        $compareMin = $interval->format('%i');
        $compareHour = $interval->format('%h');
        $compareDay = $interval->format('%a');

        $days = " วันที่แล้ว";
        $hours = " ชั่วโมงที่แล้ว";
        $mins = " นาทีที่แล้ว";
        $secs = " วินาทีที่แล้ว";

        if ($compareDay > 7) {
            return $this->DatetimeThai($date);
        } else if ($compareDay > 1) {
            return $compareDay . $days;
        } else if ($compareHour > 1) {
            return $compareHour . $hours;
        } else if ($compareMin > 1) {
            return $compareMin . $mins;
        } else {
            return $compareSec . $secs;
        }
    }

    public function LineNotify($xLineMsg)
    {
        if ($_SERVER['HTTP_HOST'] == 'localhost:8080') {
            return true;
        }
        $xToken = 'kidnPxnSX7BFfLFuy1iZY8W48VouWc2Ym8OWX9WZiWN';
        $yResult = 1;
        if ($xToken != null) {
            $chOne = curl_init();
            curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
            curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($chOne, CURLOPT_POST, 1);
            curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=" . $xLineMsg . "\n| " . date('d/m/Y H:i:s'));
            curl_setopt($chOne, CURLOPT_HTTPHEADER, [
                'Content-Type: application/x-www-form-urlencoded',
                'Authorization: Bearer ' . $xToken
            ]);
            curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($chOne);
            $result2 = json_decode($result, true);
            if ($result2['status'] == 401) {
                $yResult = 1; //เกิดข้อผิดพลาด
            } else {
                $yResult = 0; //สำเร็จ
            }

            curl_close($chOne);
        }
        return $yResult;
    }
    public function DateThai($date)
    {
        $date = strtotime($date);
        $thai_month_arr = array(
            "0" => "",
            "1" => "ม.ค.",
            "2" => "ก.พ.",
            "3" => "มี.ค.",
            "4" => "เม.ย.",
            "5" => "พ.ค.",
            "6" => "มิ.ย.",
            "7" => "ก.ค.",
            "8" => "ส.ค",
            "9" => "ก.ย.",
            "10" => "ต.ค.",
            "11" => "พ.ย.",
            "12" => "ธ.ค."
        );
        $thai_date_return = date("j", $date) . " " . $thai_month_arr[date("n", $date)] . " " . (date("Y", $date) + 543);
        return $thai_date_return;
    }

    public function TimeThai($date)
    {
        $date = strtotime($date);
        $thai_date_return = date("H.i", $date);
        return $thai_date_return;
    }

    public function DatetimeThai($date)
    {
        $date = strtotime($date);
        $thai_month_arr = array(
            "0" => "",
            "1" => "ม.ค.",
            "2" => "ก.พ.",
            "3" => "มี.ค.",
            "4" => "เม.ย.",
            "5" => "พ.ค.",
            "6" => "มิ.ย.",
            "7" => "ก.ค.",
            "8" => "ส.ค",
            "9" => "ก.ย.",
            "10" => "ต.ค.",
            "11" => "พ.ย.",
            "12" => "ธ.ค."
        );
        $thai_date_return = date("j", $date) . " " . $thai_month_arr[date("n", $date)] . " " . (date("y", $date) + 43) . ' ' . date("H.i", $date);
        return $thai_date_return;
    }

    public function UserLog($detail, $user_id)
    {
        // if (!$user_id) {
        //     $user_id = Yii::$app->user->id;
        // }
        $model = new UserLog();
        $model->user_id = $user_id;
        $model->detail = $detail;
        $model->created_date = Date('Y-m-d H:i:s');
        return ['status' => $model->save(false), 'user_id' => $user_id, 'detail' => $detail];
    }


    function urlSafeBase64Decode($data)
    {
        return base64_decode(str_replace(['-', '_'], ['+', '/'], $data));
    }

    function decryptMessage($encryptedMessage, $secretKey)
    {
        $encryptedMessage = $this->urlSafeBase64Decode($encryptedMessage);

        // Get the IV size for AES-256-CBC
        $iv_length = openssl_cipher_iv_length('aes-256-cbc');

        // Extract the IV
        $iv = substr($encryptedMessage, 0, $iv_length);

        // Extract the cipher text
        $cipherText = substr($encryptedMessage, $iv_length);

        // Decrypt the cipher text
        $decryptedMessage = openssl_decrypt($cipherText, 'aes-256-cbc', $secretKey, OPENSSL_RAW_DATA, $iv);

        return $decryptedMessage;
    }
    function urlSafeBase64Encode($data)
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($data));
    }

    function encryptMessage($message, $secretKey)
    {
        $iv_length = openssl_cipher_iv_length('aes-256-cbc');
        $iv = openssl_random_pseudo_bytes($iv_length);
        $encryptedMessage = openssl_encrypt($message, 'aes-256-cbc', $secretKey, OPENSSL_RAW_DATA, $iv);
        $encryptedMessage = $iv . $encryptedMessage;
        return $this->urlSafeBase64Encode($encryptedMessage);
    }

    public function dateDiff($stDate, $endDate) // ฟังก์ชั่นเปรียบเทียบเวลากับปัจจุบัน
    {
        $datetime = date_create($stDate);
        $dateNow = date_create($endDate);

        $interval = date_diff($datetime, $dateNow);
        $compareSec = $interval->format('%s');
        $compareMin = $interval->format('%i');
        $compareHour = $interval->format('%h');
        $compareDay = $interval->format('%a');

        $days = " วัน";
        $hours = " ชั่วโมง";
        $mins = " นาที";
        $secs = " วินาที";

        if ($compareDay > 7) {
            return 'นานมากกว่า 7 วัน';
        } else if ($compareDay > 1) {
            return $compareDay . $days;
        } else if ($compareHour > 1) {
            return $compareHour . $hours;
        } else if ($compareMin > 1) {
            return $compareMin . $mins;
        } else {
            return $compareSec . $secs;
        }
    }
}
