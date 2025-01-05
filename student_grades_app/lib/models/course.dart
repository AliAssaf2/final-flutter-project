class Course {
  final int id;
  final String name;
  final String code;

  Course({
    required this.id,
    required this.name,
    required this.code,
  });

  // Factory method to create a Course object from JSON
  factory Course.fromJson(Map<String, dynamic> json) {
    return Course(
      id: json['CourseID'],
      name: json['CourseName'],
      code: json['CourseCode'],
    );
  }

  // Method to convert a Course object to JSON for API requests
  Map<String, dynamic> toJson() {
    return {
      'CourseID': id,
      'CourseName': name,
      'CourseCode': code,
    };
  }
}
