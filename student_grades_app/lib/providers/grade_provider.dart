import 'dart:convert';
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import '../models/grade.dart';

class GradeProvider with ChangeNotifier {
  List<Grade> _grades = [];
  String _errorMessage = '';

  List<Grade> get grades => _grades;
  String get errorMessage => _errorMessage;

  Future<void> fetchGrades(int studentId) async {
    final url = Uri.parse(
        'http://localhost/student_grades_api/routes/get_student_grades.php?student_id=$studentId');

    try {
      final response = await http.get(url);

      if (response.statusCode == 200) {
        if (response.headers['content-type']?.contains('application/json') ??
            false) {
          final data = json.decode(response.body)['data'] as List;
          _grades = data.map((grade) => Grade.fromJson(grade)).toList();
          _errorMessage = '';
        } else {
          _errorMessage = 'Invalid response format';
        }
      } else {
        _errorMessage = 'Failed to load grades';
      }
    } catch (error) {
      _errorMessage = 'An error occurred: $error';
    }
    notifyListeners();
  }
}
