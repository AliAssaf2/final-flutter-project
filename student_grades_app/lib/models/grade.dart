class Grade {
  final String courseName;
  final String grade;

  Grade({required this.courseName, required this.grade});

  factory Grade.fromJson(Map<String, dynamic> json) {
    return Grade(
      courseName: json['CourseName'],
      grade: json['Grade'],
    );
  }
}
