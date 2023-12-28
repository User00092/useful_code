def calculate_points(max_points: float, min_points: float, max_time: float, time_taken: float):
    if time_taken <= 0:
        return max_points
    elif time_taken >= max_time:
        return min_points
    else:
        slope = (max_points - min_points) / max_time
        return max_points - slope * time_taken
