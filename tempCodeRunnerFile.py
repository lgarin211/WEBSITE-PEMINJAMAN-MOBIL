def calculate_nth_odd_number(N):
    if N == 1:
        return 1
    else:
        return calculate_nth_odd_number(N-1) + 2
    
print(calculate_nth_odd_number(2))