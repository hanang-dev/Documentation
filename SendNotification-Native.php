function sendNotification($userId, $title, $message, $payload)
{
    try {
        $NewResult = new database();
        $NewResult->query("SELECT DISTINCT token FROM dt_firebase WHERE ms_anggota_id = '$userId' ORDER BY updated_at DESC LIMIT 3");
        $queryResult = $NewResult->tampilkan();
        if ($queryResult != null) {
            $tokens = array();

            foreach ($queryResult as $key => $row) {
                if ($key == "token") {
                    if (!in_array($row, $tokens)) {
                        $tokens[] = $row;
                    }
                }
            }

            if (count($tokens) > 0) {
                $apiKey = "AAAAAW5X4Qc:APA91bHjadWuniMrC3SoH4YZeyxefEAImedD77Jmqc4BMFS3tz4qX1_vciss_JIxWnpXK6TmRN_aVTE9i4789xggm2-L-9jPFzbnGB9O_fFcT1-GNok0YVC_1jckggJr0N5CXIn5jLme";
                //$apiKey = "AAAAzJ5s-zI:APA91bHt1xbLiBiIXbfK_6zE1bUR7yqqqAAuFvGaCg5EATiXuUMHUTA2DttesqWbVqbWTEzNdSVD2C-pADHfOoskZtHFoXzIp7bw6B2nP8zddueke4_6x8wZwr6j5nqMbK5-c5_5Vrjr";
                $fcmUrl = 'https://fcm.googleapis.com/fcm/send';

               $notification = [
                    'title' => $title,
                    'body' =>  $message,
                    'icon' => 'logohome'
                ];

                

                $fcmNotification = [
                    "registration_ids"=> $tokens,
                    'notification' => $notification,
                    'data' => $payload,
                    'priority' => 'high',
                ];

                $headers = [
                    'Authorization: key=' . $apiKey,
                    'Content-Type: application/json'
                ];

                 $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $fcmUrl);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
                $result = curl_exec($ch);
                curl_close($ch);

                return $result;
            }
        }
    } catch (Exception $e) {
    }
}
