pipeline {
    agent any

    stages {
        stage('Clone') {
            steps {
                git 'https://github.com/saniya-mallick/Artwave-website.git'
            }
        }

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
                echo 'Deploying Artwave Website...'
            }
        }
    }
}