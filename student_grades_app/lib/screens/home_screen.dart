import 'package:flutter/material.dart';
import 'student_details_screen.dart';

class HomeScreen extends StatelessWidget {
  final TextEditingController _studentIdController = TextEditingController();

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Student Grades App'),
      ),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          children: [
            TextField(
              controller: _studentIdController,
              keyboardType: TextInputType.number,
              decoration: InputDecoration(
                labelText: 'Enter Student ID',
                border: OutlineInputBorder(),
              ),
            ),
            SizedBox(height: 20),
            ElevatedButton(
              onPressed: () {
                final studentId = int.tryParse(_studentIdController.text);
                if (studentId != null) {
                  Navigator.push(
                    context,
                    MaterialPageRoute(
                      builder: (context) =>
                          StudentDetailsScreen(studentId: studentId),
                    ),
                  );
                } else {
                  ScaffoldMessenger.of(context).showSnackBar(
                    SnackBar(content: Text('Please enter a valid Student ID')),
                  );
                }
              },
              child: Text('Get Grades'),
            ),
          ],
        ),
      ),
    );
  }
}
