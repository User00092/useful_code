function executeWithNamedParameters(\mysqli $conn, string $sql, array $namedValues): false|\mysqli_stmt  {
    $newSQL = "";
    $listValues = [];
    $listValuesTypes = '';

    $sql = preg_replace('/([(),=])+/', ' $1 ', $sql);

    $parts = explode(' ', $sql);
    foreach ($parts as $part) {
        $part = trim($part);

        if (str_starts_with($part, ":")) {
            $newSQL .= " ?";

            If (!isset($namedValues[$part])) {
                throw new \Exception("Error retrieving the key: \"$part\"");
            }


            $value = $namedValues[$part];
            $listValues[] = $value;

            if (is_int($value)) {
                $listValuesTypes .= 'i';
            } else if (is_double($value)) {
                $listValuesTypes .= 'd';
            } else {
                $listValuesTypes .= 's';
            }

        } else {
            $newSQL .= " " . $part;
        }
    }

    $newSQL = str_replace('  ', ' ', $newSQL);

    $stmt = $conn->prepare($newSQL);
    if (!$stmt) {
        throw new \Exception("Error in preparing statement: " . $conn->error);
    }

    $stmt->bind_param($listValuesTypes, ...$listValues);

    if (!$stmt->execute()) {
        return false;
    }

    return $stmt;
}
