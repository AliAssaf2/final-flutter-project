import 'package:flutter/material.dart';
import '../models/grade.dart';

class GradeTable extends StatelessWidget {
  final List<Grade> grades;

  GradeTable({required this.grades});

  @override
  Widget build(BuildContext context) {
    return DataTable(
      columns: [
        DataColumn(label: Text('Course Name')),
        DataColumn(label: Text('Grade')),
      ],
      rows: grades
          .map(
            (grade) => DataRow(
              cells: [
                DataCell(Text(grade.courseName)),
                DataCell(Text(grade.grade)),
              ],
            ),
          )
          .toList(),
    );
  }
}
