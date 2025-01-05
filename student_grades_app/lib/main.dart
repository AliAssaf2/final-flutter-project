import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'providers/grade_provider.dart';
import 'screens/home_screen.dart';

void main() {
  runApp(MyApp());
}

class MyApp extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MultiProvider(
      providers: [
        ChangeNotifierProvider(create: (_) => GradeProvider()),
      ],
      child: MaterialApp(
        debugShowCheckedModeBanner: false,
        title: 'Student Grades App',
        home: HomeScreen(),
      ),
    );
  }
}
