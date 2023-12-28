def calculate_points(max_points: float, min_points: float, max_time: float, time_taken: float, reverse: bool = False):
    if time_taken <= 0:
        return max_points if not reverse else min_points
    elif time_taken >= max_time:
        return min_points if not reverse else max_points
    else:
        if not reverse:
            slope = (max_points - min_points) / max_time
            return max_points - slope * time_taken
        else:
            slope = (max_points - min_points) / max_time
            return min_points + slope * time_taken
