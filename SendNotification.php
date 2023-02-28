    <?php
    
    public function sendNotifikasi($userId, $title, $message, $payload)
    {
        $queryResult = DB::table('dt_firebase')->select('token')->where('ms_anggota_id', $userId)->orderBy('updated_at', 'asc')->get();
        if ($queryResult != NULL) {

            $tokens = array();
            
                foreach ($queryResult as $key => $row) {
                    $tokens[] = $row->token;
                }
        
             echo count($tokens);
             if (count($tokens) > 0) {
                $apiKey = "AAAAAW5X4Qc:APA91bHjadWuniMrC3SoH4YZeyxefEAImedD77Jmqc4BMFS3tz4qX1_vciss_JIxWnpXK6TmRN_aVTE9i4789xggm2-L-9jPFzbnGB9O_fFcT1-GNok0YVC_1jckggJr0N5CXIn5jLme";
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
    }
    
    ?>
