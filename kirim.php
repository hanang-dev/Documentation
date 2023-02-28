<?php
 $idNotif = Notifikasi::insertGetId([
                        'ms_anggota_id' => $idangggotadispo,
                        'judul' => $judul,
                        'keterangan' => $pesan_notif,
                        'nama_tabel' => 'dt_disposisi',
                        'nama_field' => 'dt_disposisi_id',
                        'id' => $id_dispo,
                        'file_name' => 'disposisi',
                    ]);

NotifikasiController::sendNotifikasi("$idangggotadispo", "$judul", "$pesan_notif", array("rute" => "/disposisi", "id" => "$id_dispo"));



?>
