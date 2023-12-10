function executeWithNamedParameters(\mysqli $conn, string $sql, array $namedValues): false|\mysqli_stmt  {
    $newSQL = "";
    $listValues = [];
    $listValuesTypes = '';

    $parts = explode(' ', $sql);
    foreach ($parts as $part) {
        $part = trim($part);

        if (str_starts_with($part, ":")) {
            $newSQL .= " ?";

            $value = $namedValues[$part] ?? null;

            if ($value == null) {
                throw new \Exception("Error retrieving the key: \"$part\"");
            }

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
