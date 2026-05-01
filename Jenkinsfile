pipeline {
    agent any

    stages {
        stage('Build') {
            steps {
                echo 'Building Artwave Website...'
            }
        }

        stage('Test') {
            steps {
                echo 'Testing Artwave Website...'
            }
        }

        stage('Deploy') {
            steps {
                bat 'xcopy /E /I /Y * C:\\xampp\\htdocs\\Music'
                echo 'Deployment completed successfully'
            }
        }
    }
}