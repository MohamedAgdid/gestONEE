if ($data && !empty($data['matricules'])) {
            $selectedVehicles = explode(',', $data['matricules']);
            $stmt = $pdo->prepare("select matricule from vehicule WHERE id = ?");
            foreach ($selectedVehicles as $vehicleId) {
            $vehicleId = htmlspecialchars($vehicleId);
            $stmt->execute([$vehicleId]);
            $matricule = $stmt->fetchColumn();
            if ($matricule !== false) {
                   $matriculeArray[] = htmlspecialchars($matricule);
             }
            }
            $matriculesConcatenated = implode('|', $matriculeArray);
            
            
        }