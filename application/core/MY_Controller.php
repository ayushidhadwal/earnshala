<?php

class MY_Controller extends CI_Controller
{

    public function firebaseNotification($userId, $token, $title, $message) {
        $this->user_model->saveNotification($userId, $title, $message);

        try {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://fcm.googleapis.com/fcm/send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
                    "to": "' . $token . '",
                    "notification": {
                        "body": "' . $message . '",
                        "title": "' . $title . '",
                        "sound": "default"
                    },
                    
                }',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: key=AAAAFcqHCC4:APA91bHx26AyZxSAVL8EImGZjo_9bGyoi_hiXwf7hHJGd2N2sAiahHHd5_tbG2NxydbOmz8innjGK02DYHwBJedoTMMYdOSg0SCAGKzMr32hkrNHsASm7aCUcnbvsKqIMkLSdmC1B4lT',
                    'Content-Type: application/json'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            return true;

        } catch (Exception $e) {
            return true;
        }
    }

    public function sendNotification($userId, $title, $message)
    {
        $user = $this->db->where('id', $userId)->get('users')->row();

        if (!empty($user)) {
            $token = $user->firebase_token;
            if (!empty($token)) {
                $this->firebaseNotification($userId, $token, $title, $message);
            }
        }
    }

    public function sendNotificationToAllUsers($title, $message)
    {
        // get users list and loop through all and send notification.
        $users = $this->user_model->get_user()->result();
        foreach ($users as $user) {
            if (!empty($user->firebase_token)) {
                $this->firebaseNotification($user->id, $user->firebase_token, $title, $message);
            }
        }
    }

    public function sendBulkSms($type, $mobile, $otp)
    {
        if ($type === 'Change') {
            $msg = "Dear user, Your OTP for Change Password is $otp. Do not share OTP with anyone. EARNSHALA WINGSTAR MEDIA";
        } elseif ($type === 'Reset') {
            $msg = "Dear user, Your OTP for Reset Password is $otp. Do not share OTP with anyone. EARNSHALA WINGSTAR MEDIA";
        } elseif ($type === 'Verify') {
            $msg = "Dear user, Your OTP for registration is $otp Use this password to validate your Login. Do Not Share OTP with anyone. EARNSHALA WINGSTAR MEDIA";
        } else {
            return true;
        }

        $smsType = 'TRANS';
        $apiKey = '44658115-2ad8-4103-b744-ea46edf9b099';
        $senderName = 'WNGSTR';
        $username = 'mediawing';

        $msg = urlencode($msg);

        $url = "http://sms.bulksmsind.in/v2/sendSMS?username=$username&message=$msg&sendername=$senderName&smstype=$smsType&numbers=$mobile&apikey=$apiKey";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $msg);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        $response = curl_exec($ch);

        curl_close($ch);
        if (empty($response)) {
            return false;
        } else {
            return true;
        }
    }

    public function sendEmail($toName, $toEmail, $subject, $msg)
    {
        // send OTP API
        $url = "https://api.sendinblue.com/v3/smtp/email";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Api-Key: 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';
        $headers[] = 'Content-Type: application/json';

        $data = [
            'sender' => [
                'name' => 'no-reply@earnshalaadmin.com',
                'email' => 'EARNSHALA WINGSTAR MEDIA',
            ],
            'to' => [
                [
                    "email" => $toEmail,
                    "name" => $toName
                ]
            ],
            "subject" => $subject,
            "htmlContent" => $msg
        ];

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

        $resp = curl_exec($curl);

        curl_close($curl);
        return true;
    }
}