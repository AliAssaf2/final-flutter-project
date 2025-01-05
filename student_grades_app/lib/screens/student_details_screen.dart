import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import '../providers/grade_provider.dart';
import '../widgets/grade_table.dart';

class StudentDetailsScreen extends StatelessWidget {
  final int studentId;

  StudentDetailsScreen({required this.studentId});

  @override
  Widget build(BuildContext context) {
    final gradeProvider = Provider.of<GradeProvider>(context, listen: false);

    return Scaffold(
      appBar: AppBar(
        title: Text('Student Grades'),
      ),
      body: FutureBuilder(
        future: gradeProvider.fetchGrades(studentId),
        builder: (ctx, snapshot) {
          if (snapshot.connectionState == ConnectionState.waiting) {
            return Center(child: CircularProgressIndicator());
          } else {
            return Consumer<GradeProvider>(
              builder: (ctx, provider, child) {
                if (provider.errorMessage.isNotEmpty) {
                  return Center(
                    child: Text(provider.errorMessage),
                  );
                }

                return GradeTable(grades: provider.grades);
              },
            );
          }
        },
      ),
    );
  }
}
