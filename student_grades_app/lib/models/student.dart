class Student {
  final int id;
  final String firstName;
  final String lastName;

  Student({required this.id, required this.firstName, required this.lastName});

  factory Student.fromJson(Map<String, dynamic> json) {
    return Student(
      id: json['StudentID'],
      firstName: json['FirstName'],
      lastName: json['LastName'],
    );
  }
}
